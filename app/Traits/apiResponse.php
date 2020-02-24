<?php
namespace App\Traits;

trait apiResponse
{
    public function responseAPI($data)
    {
        $successReturn = [
                "data"=>$data
        ];
        return response()->json($successReturn);
    }

    // future state errrrs shoudl be handlerer
    private function notFoundMessage()
    {
        return [
            'code' => 404,
            'message' => 'Note not found',
            'success' => false,
        ];
    }


    private function successfulMessage($code, $message, $status, $count, $payload)
    {
        return [
            'code' => $code,
            'message' => $message,
            'success' => $status,
            'count' => $count,
            'data' => $payload,
        ];
    }
}
