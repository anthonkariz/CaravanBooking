<?php

namespace App\Util;

trait HttpResponse
{
    public function successResponse($message, $data = null, $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json([
            'message' => $message,
            'code' => $code
        ], $code);
    }
}
