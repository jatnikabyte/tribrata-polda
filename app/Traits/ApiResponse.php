<?php

namespace App\Traits;

use App\Helpers\JT\ApiResponse as JTResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponse
{
    public function success(mixed $data = null, string $message = 'Request successful', int $code = 200, array $meta = []): JsonResponse
    {
        return JTResponse::success($data, $message, $code, $meta);
    }

    public function paginated(LengthAwarePaginator|Collection $data, string $message = 'Data retrieved successfully', int $code = 200): JsonResponse
    {
        return JTResponse::paginated($data, $message, $code);
    }

    public function paginatedResource(ResourceCollection $data, string $message = 'Data retrieved successfully', int $code = 200): JsonResponse
    {
        return JTResponse::paginatedResource($data, $message, $code);
    }

    public function created(mixed $data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return JTResponse::created($data, $message);
    }

    public function updated(mixed $data = null, string $message = 'Resource updated successfully'): JsonResponse
    {
        return JTResponse::updated($data, $message);
    }

    public function deleted(string $message = 'Resource deleted successfully'): JsonResponse
    {
        return JTResponse::deleted($message);
    }

    public function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return JTResponse::notFound($message);
    }

    public function validationError(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return JTResponse::validationError($errors, $message);
    }

    public function unauthorized(string $message = 'Unauthorized access'): JsonResponse
    {
        return JTResponse::unauthorized($message);
    }

    public function forbidden(string $message = 'You do not have permission to access this resource'): JsonResponse
    {
        return JTResponse::forbidden($message);
    }

    public function badRequest(string $message = 'Bad request', array $errors = []): JsonResponse
    {
        return JTResponse::badRequest($message, $errors);
    }

    public function serverError(string $message = 'Internal server error', mixed $details = null): JsonResponse
    {
        return JTResponse::serverError($message, $details);
    }

    public function custom(bool $success, string $message, mixed $data = null, int $code = 200, array $extra = []): JsonResponse
    {
        return JTResponse::custom($success, $message, $data, $code, $extra);
    }
}
