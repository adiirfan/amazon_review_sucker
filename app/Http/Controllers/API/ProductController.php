<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProduct;

class ProductController extends Controller
{
    protected $userId;
    public function __construct()
    {
    }

    public function index(){
        $userId = Auth::id();

        $limit = app('request')->get('limit');
        $page = app('request')->get('page');

        return UserProduct::where('userId',$userId)
            ->with('Product')
            ->with('queue')
            ->orderBy('id','DESC')->paginate(
            $limit ?? 10,
            ['*'],
            'page',
            $page ?? 1
        );
    }
    public function single($ASIN){
        $userId = Auth::id();
        $data = UserProduct::where('userId',$userId)
            ->where('ASIN',$ASIN)
            ->with('Product')
            ->with('queue')
            ->orderBy('id','DESC')->first();
        if(empty($data)){
            return $this->ErrorHandlers('data not found');
        }
        return $data;
    }
}
