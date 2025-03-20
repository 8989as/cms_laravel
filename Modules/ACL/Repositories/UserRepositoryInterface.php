<?php 

namespace Modules\ACL\Repositories;

interface UserRepositoryInterface
{
    public function findByEmail(string $email);
}