<?php

namespace Modules\ACL\App\Http\Controllers;

use Modules\ACL\App\Http\Requests\LoginRequest;
use Modules\ACL\App\Http\Requests\ForgotPasswordRequest;
use Modules\ACL\Services\AuthService;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->login($request->validated());

        if (isset($response['error'])) {
            return app('ResponseHelper')::errorResponse($response['error'], $response['status']);
        }

        return app('ResponseHelper')::successResponse($response, 'Login successful', $response['status']);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $response = $this->authService->forgotPassword($request->validated());

        return $response['status'] === 200
            ? app('ResponseHelper')::successResponse([], $response['message'], $response['status'])
            : app('ResponseHelper')::errorResponse($response['message'], $response['status']);
    }
}
