<?php

namespace App\Http\Controllers\API;

use App\Jobs\scrapeJob;
use App\Models\Product;
use App\Models\QueueStatus;
use App\Models\Notification;
use Goutte\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProduct;
use Illuminate\Support\Facades\DB;

class ScrapeController extends Controller
{
    protected $goutte;

    public function __construct()
    {
        $this->goutte = new Client([
            'proxy' => 'tcp://125.25.54.65:47000',
        ]);
        $rand = rand(1,2);
        $user_agent[2] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36';
        $user_agent[1] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36';
        $this->goutte->setHeader('User-Agent', $user_agent[$rand]);
    }

    public function index(Request $request){
        $userId = Auth::id();
        $check = UserProduct::where('userId',$userId)->where('ASIN',$request['ASIN'])->first();
        if(!empty($check)){
            return $this->SuksesHandlers('Already Registered');
        }
        if(!$this->productCheck($request['ASIN'])){
            return $this->ErrorHandlers('ASIN not found');
        }
        $data = [
            'ASIN' => $request['ASIN'],
            'userId' => $userId,
        ];
        $product = Product::where('ASIN',$request['ASIN'])->first();
        if(!empty($product)){
            return $this->SuksesHandlers($data);
        }
        $insert =  $this->insert($data);
        if($insert){
            dispatch(new scrapeJob($request['ASIN']))->delay(10);
            return $this->SuksesHandlers($data);
        }
        return $this->ErrorHandlers('Error While Insert Data');
    }
    function insert($data){
        DB::beginTransaction();
        Product::create($data);
        QueueStatus::create($data);
        Notification::create($data);
        $product = UserProduct::create($data);
        DB::commit();
        if($product){
            return true;
        }
        return false;
    }

    function productCheck($ASIN){
        $page = 1;
        $crawler = $this->goutte->request('GET', 'https://www.amazon.com/product-reviews/' . $ASIN . '/ref=cm_cr_arp_d_paging_btm_next_2?ie=UTF8&sortBy=recent&pageNumber=' . $page);
        if(!$crawler){
            return false;
        }
        $check404 = $crawler->filter('img[alt="Dogs of Amazon"]')->count();
        if ($check404 > 0) {
            return false;
        }
        return true;
    }
}

