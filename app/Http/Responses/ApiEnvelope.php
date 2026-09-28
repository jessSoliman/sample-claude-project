<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * The single source of truth for the JSON response envelope:
 * { success, status_code, message, data }.
 *
 * Controllers reach this through the ApiResponse trait; the API exception
 * renderer in bootstrap/app.php calls it directly. Nothing else may build
 * a JSON response body by hand.
 */
final class ApiEnvelope
{
    public static function success(mixed $data = null, ?string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return self::make(true, $statusCode, $message ?? __('messages.success'), $data);
    }

    public static function error(?string $message = null, int $statusCode = Response::HTTP_BAD_REQUEST, mixed $data = null): JsonResponse
    {
        return self::make(false, $statusCode, $message ?? __('messages.errors.generic'), $data);
    }

    public static function make(bool $success, int $statusCode, string $message, mixed $data = null): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
