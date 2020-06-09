<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $code = 200){
        $response=[
            'code'=>$code,
            'msg'=>'請求成功',
            'data'=>$result
        ];
        return response()->json($response);
    }

    public function sendError($errorMessages = [], $code = 404)
    {
        $response = [
            'code' => $code,
            'msg' => '驗証失敗',
            'data'=> $errorMessages
        ];
        return response()->json($response, $code);
    }

}
