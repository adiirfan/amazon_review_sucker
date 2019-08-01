<?php

namespace App\Http\Controllers\API;

use App\Jobs\scrapeJob;
use App\Models\Product;
use App\Models\QueueStatus;
use App\Models\Notification;
use App\User;
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

    }

    public function index(Request $request){
        $userId = Auth::id();
        $check = UserProduct::where('userId',$userId)->where('ASIN',$request['ASIN'])->first();
        if(!empty($check)){
            return $this->ErrorHandlers('sudah terdaftar');
        }
        $data = [
            'ASIN' => $request['ASIN'],
            'userId' => $userId,
        ];
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
}

