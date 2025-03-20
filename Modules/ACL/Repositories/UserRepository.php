<?php

namespace Modules\ACL\Repositories;

use Modules\ACL\App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}