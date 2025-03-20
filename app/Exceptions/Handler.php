<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Modules\Base\Helpers\ResponseHelper;
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return ResponseHelper::errorResponse('Validation error', 422, [], $e->errors());
        }
    
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return ResponseHelper::errorResponse('Unauthorized', 401);
        }
    
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return ResponseHelper::errorResponse('Endpoint not found', 404);
        }

        // Default exception handling
        return parent::render($request, $e);
    }
}
