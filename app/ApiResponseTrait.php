<?php

namespace App;

trait ApiResponseTrait
{
    public function successResponse($data = null, $message = null)
    {
        $response = [
            'message' => $message ?? "Operation Success",
        ];
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        return response()->json($response);
    }

    public function errorResponse($error, $statusCode = 500)
    {
        $error = $error instanceof \Throwable ? $error->getMessage() : $error;
        $response = [
            'error' => $error,
        ];
        return response()->json($response, $statusCode);
    }

    public function customresponse($data = null, $message = null, $statusCode = null)
    {
        $response = [
            'message' => $message,
            'data' => $data,
            'statusCode' => $statusCode,
        ];

        return response()->json($response, $statusCode);
    }
}
