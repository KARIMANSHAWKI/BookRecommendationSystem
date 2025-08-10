<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('apiResponse')) {
    function apiResponse(array $data = [], string $message = ''): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ]);
    }
}


if (!function_exists('uploadImage')) {
    function uploadImage($file): string
    {
        $imageName = time() . '_' . Str::random(8) . '.' . $file->extension();
        $path = '/users/' . $imageName;
        Storage::disk('public')->put($path, File::get($file));
        return $path;
    }
}


if (!function_exists('getFileContent')) {
    function getFileContent($fileName, $disk = 'local'): array
    {
        return json_decode(
            Storage::disk($disk)->get($fileName),
            true
        );
    }
}
