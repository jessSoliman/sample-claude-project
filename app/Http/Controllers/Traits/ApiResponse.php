<?php

namespace App\Http\Controllers\Traits;

use App\Http\Responses\ApiEnvelope;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Respond with a success envelope that carries no payload.
     */
    protected function successResponse(?string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return ApiEnvelope::success(null, $message, $statusCode);
    }

    /**
     * Respond with a success envelope wrapping the given payload.
     */
    protected function successWithDataResponse(mixed $data, ?string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return ApiEnvelope::success($data, $message, $statusCode);
    }

    /**
     * Respond with an error envelope.
     */
    protected function errorResponse(?string $message = null, int $statusCode = Response::HTTP_BAD_REQUEST, mixed $data = null): JsonResponse
    {
        return ApiEnvelope::error($message, $statusCode, $data);
    }

    /**
     * Halt the request immediately with an error envelope.
     */
    protected function abort(?string $message = null, int $statusCode = Response::HTTP_BAD_REQUEST, mixed $data = null): never
    {
        throw new HttpResponseException($this->errorResponse($message, $statusCode, $data));
    }
}
