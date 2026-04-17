<?php

namespace App\Helpers\JT;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApiResponse
{
    /**
     * Success response
     */
    public static function success(
        mixed $data = null,
        string $message = 'Request successful',
        int $code = 200,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (! is_null($data)) {
            $response['data'] = $data;
        }

        if (! empty($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }

    /**
     * Success response with pagination
     */
    public static function paginated(
        LengthAwarePaginator|Collection $data,
        string $message = 'Data retrieved successfully',
        int $code = 200
    ): JsonResponse {
        $meta = [
            'current_page' => $data->currentPage() ?? 1,
            'per_page' => $data->perPage() ?? count($data),
            'total' => $data->total() ?? count($data),
            'last_page' => method_exists($data, 'lastPage') ? $data->lastPage() : 1,
        ];

        return self::success(
            $data->items() ?? $data,
            $message,
            $code,
            $meta
        );
    }

    /**
     *  For: Resource::collection($paginator)
     */
    public static function paginatedResource(
        ResourceCollection $resource,
        string $message = 'Data retrieved successfully',
        int $code = 200
    ): JsonResponse {
        $paginator = $resource->resource; // extract paginator

        $data = [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'data' => $resource->items(),
        ];

        return self::success($data, $message, $code);
    }

    /**
     * Created (201)
     */
    public static function created(
        mixed $data = null,
        string $message = 'Resource created successfully'
    ): JsonResponse {
        return self::success($data, $message, 201);
    }

    /**
     * Updated (200)
     */
    public static function updated(
        mixed $data = null,
        string $message = 'Resource updated successfully'
    ): JsonResponse {
        return self::success($data, $message, 200);
    }

    /**
     * Deleted (200)
     */
    public static function deleted(string $message = 'Resource deleted successfully'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    /**
     * Not found (404)
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404);
    }

    /**
     * Validation error (422)
     */
    public static function validationError(
        array $errors,
        string $message = 'Validation failed'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Unauthorized (401)
     */
    public static function unauthorized(
        string $message = 'Unauthorized access',
        $error = 'UNAUTHORIZED'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error_code' => $error,
        ], 401);
    }

    /**
     * Forbidden (403)
     */
    public static function forbidden(
        string $message = 'You do not have permission to access this resource'
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 403);
    }

    /**
     * Bad request (400)
     */
    public static function badRequest(
        string $message = 'Bad request',
        array $errors = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (! empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, 400);
    }

    /**
     * Server error (500)
     */
    public static function serverError(
        string $message = 'Internal server error',
        mixed $details = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($details) {
            $response['error_details'] = $details;
        }

        return response()->json($response, 500);
    }

    /**
     * Custom response
     */
    public static function custom(
        bool $success,
        string $message,
        mixed $data = null,
        int $code = 200,
        array $extra = []
    ): JsonResponse {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (! is_null($data)) {
            $response['data'] = $data;
        }

        if (! empty($extra)) {
            $response = array_merge($response, $extra);
        }

        return response()->json($response, $code);
    }
}
