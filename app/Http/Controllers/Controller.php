<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function ErrorHandlers($msg){
        return response()->json(["code"=> 0 , "message" => "forbidden" , "errors" =>$msg], 404);
    }
    public function SuksesHandlers($data){
        return response()->json(["code"=> 1 , "message" => "success", "data" => $data], 200);
    }
}
