<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data = null, string $message = 'Operation successful', int $status = HttpResponse::HTTP_OK) {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data,
            ], $status);
        });

        Response::macro('error', function (string $message = 'An error occurred', int $status = HttpResponse::HTTP_BAD_REQUEST, $errors = null) {
            return Response::json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], $status);
        });

        Response::macro('badRequest', function (string $message = 'Bad request', $errors = null) {
            return Response::json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], HttpResponse::HTTP_BAD_REQUEST);
        });

        Response::macro('unauthorized', function (string $message = 'Unauthorized') {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], HttpResponse::HTTP_UNAUTHORIZED);
        });

        Response::macro('forbidden', function (string $message = 'Forbidden') {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], HttpResponse::HTTP_FORBIDDEN);
        });

        Response::macro('notFound', function (string $message = 'Resource not found') {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], HttpResponse::HTTP_NOT_FOUND);
        });

        Response::macro('unprocessableEntity', function (string $message = 'Unprocessable entity', $errors = null) {
            return Response::json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        });

        Response::macro('serverError', function (string $message = 'Internal server error') {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        });

        Response::macro('created', function ($data = null, string $message = 'Resource created successfully') {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data,
            ], HttpResponse::HTTP_CREATED);
        });

        Response::macro('noContent', function () {
            return Response::json(null, HttpResponse::HTTP_NO_CONTENT);
        });

        Response::macro('paginatedSuccess', function ($data, string $message = 'Data retrieved successfully') {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data->items(),
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ],
            ], HttpResponse::HTTP_OK);
        });
    }
}

