<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use App\Models\TagsReview;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Tags;

class ReviewController extends Controller
{
    public function index($ASIN){
        $page = app('request')->get('page');
        $limit = app('request')->get('limit');
        $star = app('request')->get('star');
        $verif = app('request')->get('verif');
        $userId = Auth::id();
        $check = UserProduct::where('userId', $userId)->where('ASIN', $ASIN)->first();
        if (!$check) {
            return $this->ErrorHandlers('Product Not Registered');
        }

        $review = Review::where('ASIN', $ASIN);
        if(!is_null($verif)){
            $review = $review->where('verif',$verif);
        }
        if(!empty($star)){
            $review = $review->filterStar($star);
        }
        return $review->orderBy('id', 'ASC')->paginate(
            $limit ?? 10,
            ['*'],
            'page',
            $page ?? 1
        );

    }

    public function getAVG($ASIN){
        $review = Review::selectRaw('AVG(rating) AS avg')
            ->where('ASIN', $ASIN)
            ->groupBy('ASIN')
            ->first();
        return $review;
    }

    public function getSumTotal($ASIN){
        $data = [
            'totalReview' => $this->summary($ASIN,'ASIN',$ASIN),
            'verifiedReview' => $this->summary($ASIN,'verif',1),
            'unverifiedReview' => $this->summary($ASIN,'verif',0),
            'star' => [
                $this->summary($ASIN,'rating',5),
                $this->summary($ASIN,'rating',4),
                $this->summary($ASIN,'rating',3),
                $this->summary($ASIN,'rating',2),
                $this->summary($ASIN,'rating',1),
            ]
        ];
        return $data;
    }

    function summary($ASIN,$filter,$by = null){
        $userId = Auth::id();
        $check = UserProduct::where('userId',$userId)->where('ASIN',$ASIN)->first();
        if(!$check){
            return $this->ErrorHandlers('Product Not Registered');
        }
        if((!is_null($filter) && !is_null($by))) {
            $review = Review::selectRaw('COUNT(' . $filter . ') AS total')
                ->where($filter, $by)
                ->where('ASIN', $ASIN)
                ->groupBy('ASIN')
                ->first();
            return $review['total'];
        }
        return $this->ErrorHandlers('Param Error');
    }
}
