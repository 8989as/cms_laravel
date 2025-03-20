<?php 

namespace Modules\ACL\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Modules\ACL\Repositories\UserRepositoryInterface;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $data)
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ['error' => 'Invalid credentials', 'status' => 401];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['access_token' => $token, 'token_type' => 'Bearer', 'status' => 200];
    }

    public function forgotPassword(array $data)
    {
        $status = Password::sendResetLink(['email' => $data['email']]);

        if ($status === Password::RESET_LINK_SENT) {
            return ['message' => 'Reset link sent', 'status' => 200];
        }

        return ['message' => 'Error sending reset link', 'status' => 500];
    }
}