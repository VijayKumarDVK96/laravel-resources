<?php

namespace App\Http\Traits;

trait ApiHelperTrait
{

    public function sendResponse($result, $message = 'success', $status = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, $status);
    }

    public function sendError($error, $status)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $status);
        die;
    }
}
