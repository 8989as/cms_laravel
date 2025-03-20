<?php

namespace Modules\Base\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Success Response
     *
     * @param array $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public static function successResponse( $data = [], string $message = 'Operation successful', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

      /**
     * Return a paginated response.
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function paginatedResponse($paginator, $message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(), // The actual data
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ],
        ], $statusCode);
    }

    

    /**
     * Error Response
     *
     * @param string $message
     * @param int $status
     * @param array $data
     * @return JsonResponse
     */
    public static function errorResponse(string $message = 'An error occurred', int $status = 400, array $data = [], array $errors= []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ], $status);
    }
}