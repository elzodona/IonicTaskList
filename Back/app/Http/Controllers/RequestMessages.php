<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestMessages extends Controller
{
    public function succedRequest($result,$message,$status)
    {
        $response = [
            'status'=>$status,
            'success'=>true,
            'data'=>$result,
            'message'=>$message
        ];
        return response()->json($response);
    }

    public function errorRequest($message,$status)
    {
        $response = [
            'message'=>$message,
            'status'=>$status
        ];
        return response()->json($response);
    }
}
