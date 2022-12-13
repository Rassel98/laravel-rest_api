<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sentResponse($result,$message){
        $response=[
            'success'=>true,
            'message'=>$message,
            'data'=>$result,
        ];
        return response()->json($response,200);
    }

    public function sentError($error,$errmessage=[]){
        $response=[
            'success'=>false,
            'message'=>$error,


        ];
        if(!empty($errmessage)){
            $response['data']= $errmessage;
        }
        return response()->json($response,404);
    }
}
