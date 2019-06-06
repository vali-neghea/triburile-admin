<?php


namespace App\Helpers;


class ResponseHelper
{
    public static function responseJson($status, $success, $message, $data) {
        $response = [
          'status' => $status,
          'success' => $success,
          'message' => $message,
          'data' => $data
        ];

        return response()->json($response);
    }
}
