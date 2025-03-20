<?php

namespace Modules\ACL\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ACL\App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::UpdateOrCreate([
            "name" => "Admin"
        ],[
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
    }
}
