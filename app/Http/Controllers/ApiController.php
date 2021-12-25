<?php

namespace App\Http\Controllers;
//use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiController extends Controller
{
    // protected function respond($data, $statusCode = 200, $headers = [])
    // {
    //     return response()->json(["data" => $data, "code" => $statusCode, $headers]);
    // }

    protected function apiResponse($data = [], $message = "success", $statusCode = 200)
    {
        $responseStructure = [
            "data" => $data,
            "message" => $message,
            "statusCode" => $statusCode
        ];

        return $this->respond($responseStructure);
    }

    protected function respond($data)
    {
        return response()->json($data);
    }

    protected function respondSuccess()
    {
        return $this->respond(null);
    }

    protected function respondNoContent()
    {
        return $this->respond(null, 204);
    }

    protected function respondError($message, $statusCode)
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'type' => '',
                'code' => $statusCode,
            ],
        ], $statusCode);
    }

    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, 401);
    }

    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, 404);
    }

    protected function respondFailedLogin()
    {
        return $this->respond([
            'errors' => [
                'email or password' => 'is invalid',
            ],
        ], 422);
    }
}
