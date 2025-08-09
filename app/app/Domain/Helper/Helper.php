<?php

use Illuminate\Http\JsonResponse;

function apiResponse(array $data = [], string $message = ''): JsonResponse
{
    return response()->json([
        'message' => $message,
        'data' => $data,
    ]);
}
