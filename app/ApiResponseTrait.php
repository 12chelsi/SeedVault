<?php

namespace App;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse(string $message = 'Something went wrong', int $code = 500, $data = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function validationErrorResponse($errors, string $message = 'Validation failed'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
            'data' => null,
        ], 422);
    }
}
