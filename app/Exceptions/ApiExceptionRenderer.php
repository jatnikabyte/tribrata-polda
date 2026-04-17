<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionRenderer
{
    public static function render(Throwable $e, Request $request)
    {
        if (! $request->is('api/*')) {
            return null; // only intercept API
        }

        $isDev = isDebug();

        $statusCode = 500;
        $message = $e->getMessage() ?: 'An error occurred';
        $errors = null;

        switch (true) {
            case $e instanceof ValidationException:
                $statusCode = 422;
                $message = 'The given data was invalid';
                $errors = $e->errors();
                break;

            case $e instanceof NotFoundHttpException:
            case $e instanceof ModelNotFoundException:
                $statusCode = 404;
                $message = 'Resource not found';
                break;

            case $e instanceof AuthenticationException:
                $statusCode = 401;
                $message = 'Unauthenticated';
                break;

            case $e instanceof HttpException:
                $statusCode = $e->getStatusCode();
                $message = $e->getMessage() ?: 'An error occurred';
                break;

            case method_exists($e, 'getStatusCode'):
                $statusCode = $e->getStatusCode();
                break;
        }

        // Log only critical errors (500+)
        if ($statusCode >= 500) {
            Log::error($e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        if ($isDev) {
            $response['debug'] = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => collect($e->getTrace())->take(5),
            ];
        }

        return response()->json($response, $statusCode);
    }
}
