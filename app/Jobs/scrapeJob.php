<?php

namespace App\Jobs;

use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\QueueStatus;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class scrapeJob implements ShouldQueue
{
    protected $goutte;
    protected $ASIN;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct($asin)
    {
        $this->ASIN = $asin;
    }
    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        QueueStatus::where('ASIN',$this->ASIN)->update([
            'queueStatus' => 1,
        ]);
        $page = 1;
        if (Cache::has($this->ASIN.'_page')) {
            $page = Cache::get($this->ASIN.'_page');
        }
        $x = false;
        $failed = 0;
        $product = false;
        while(!$x) {
            $this->reGoutte();
            $crawler = $this->goutte->request('GET', 'https://www.amazon.com/product-reviews/' . $this->ASIN . '/ref=cm_cr_arp_d_paging_btm_next_2?ie=UTF8&sortBy=recent&pageNumber=' . $page);
            if(!$crawler){
                $x = false;
            }
            if(!$product){
                $countproduct = $crawler->filter('a[data-hook="product-link"]')->count();
                if($countproduct > 0){
                    Product::where('ASIN',$this->ASIN)->update([
                        'productName' => $this->getProductName($crawler),
                        'productUrl' => $this->getProductUrl($crawler)
                    ]);
                    $product = true;
                }
            }
            $count = $crawler->filter('div[data-hook="review"] ')->count();
            if($count < 1){
                $countend = $crawler->filter('div[class="a-section a-spacing-top-large a-text-center no-reviews-section"]')->count();
                if($countend > 0){
                    $x = true;
                }
                $check404 = $crawler->filter('img[alt="Dogs of Amazon"]')->count();
                if($check404 > 0){

                }
                $failed++;
                if($failed > 10){
                    sleep(10);
                    $this->reGoutte();
                    $failed = 0;
                }
                continue;
            }
            for ($i = 0; $i < $count; $i++) {
                $crawl = $crawler->filter('div[data-hook="review"]')->eq($i);
                $dataCrawl = [
                    'ASIN' => $this->ASIN,
                    'title' => $this->getTitle($crawl),
                    'body' => $this->getBody($crawl),
                    'reviewUrl' => $this->getUrl($crawl),
                    'verif' => $this->getVerified($crawl),
                    'rating' => $this->getStar($crawl),
                    'author' => $this->getName($crawl),
                    'authorUrl' => $this->getProfile($crawl),
                    'reviewDate' => $this->getDate($crawl),
                    'comment' => $this->getCommentTotal($crawl),
                    'isVideo' => $this->isVideo($crawl),
                    'isImage' => $this->isImage($crawl),
                    'votes' => $this->helpful($crawl),
                ];
                Review::create($dataCrawl);
            }
            sleep(10);
            $page++;
            Cache::forever($this->ASIN.'_page', $page);
        }
        Cache::forget($this->ASIN.'_page');
        QueueStatus::where('ASIN',$this->ASIN)->update([
            'queueStatus' => 2,
        ]);
    }
    function getTitle($crawler){
        $data = $crawler->filter('a[data-hook="review-title"] > span')->text();
        return $data;
    }
    function getBody($crawler){
        $data = $crawler->filter('span[data-hook="review-body"] > span')->text();
        return $data;
    }
    function getUrl($crawler){
        $data = $crawler->filter('a[data-hook="review-title"]')->attr('href');
        return 'https://www.amazon.com/'.$data;
    }
    function getVerified($crawler){
        if ($crawler->filter('span[data-hook="avp-badge"]')->count() > 0 ) {
            return 1;
        }
        return 0;
    }
    function getStar($crawler){
        $data = $crawler->filter('i[data-hook="review-star-rating"] > span')->text();
        $rating = explode(' ',$data);
        return $rating[0];
    }
    function getProfile($crawler){
        $data = $crawler->filter('div[data-hook="genome-widget"] > a')-> attr('href');
        return 'https://www.amazon.com/'. $data;
    }
    function getName($crawler){
        $data = $crawler->filter('div[data-hook="genome-widget"] > a > div[class="a-profile-content"] > span')->text();
        return $data;
    }
    function getDate($crawler){
        $data = $crawler->filter('span[data-hook="review-date"]')->text();
        return Carbon::createFromIsoFormat('LL', $data)->toDateString();
    }
    function getCommentTotal($crawler){
        $data = $crawler->filter('span[class="review-comment-total aok-hidden"]')->text();
        return $data;
    }
    function isVideo($crawler){
        $data = $crawler->filter('div[class="a-section a-spacing-small a-spacing-top-mini video-block"]')->count();
        if($data > 0){
            return 1;
        }
        return 0;
    }
    function helpful($crawler){
        $data = $crawler->filter('span[data-hook="helpful-vote-statement"]')->count();
        if($data > 0){
            $data = $crawler->filter('span[data-hook="helpful-vote-statement"]')->text();
            $votes = explode(' ',$data);
            if($votes[0] == 'One'){
                return 1;
            }
            if($votes[0] == 'Two'){
                return 2;
            }
            return $votes[0];
        }
        return 0;
    }
    function isImage($crawler){
        $data = $crawler->filter('div[class="review-image-tile-section"]')->count();
        if($data > 0){
            return 1;
        }
        return 0;
    }
    function getProductName($crawler){
        $data = $crawler->filter('a[data-hook="product-link"]')->text();
        return $data;
    }
    function getProductUrl($crawler){
        $data = $crawler->filter('a[data-hook="product-link"]')->attr('href');
        return 'https://www.amazon.com/'. $data;
    }
    function reGoutte(){
        $rand = rand(0,3);
        $proxyList = [
            'tcp://125.25.54.65:47000',
            'tcp://103.94.5.54:8080',
            'tcp://38.134.10.106:53281',
            'tcp://103.211.232.92:53281'
        ];
        $user_agent = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3861.0 Safari/537.36 Edg/77.0.230.2',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36',
            'Mozilla/5.0 (Linux; Android 9; SM-G960F Build/PPR1.180610.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36'
        ];

        $this->goutte = new Client([
            'proxy' => $proxyList[$rand],
        ]);
        $this->goutte->setHeader('User-Agent', $user_agent[$rand]);
        return true;
    }
}


