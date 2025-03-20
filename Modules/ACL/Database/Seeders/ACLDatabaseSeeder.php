<?php

namespace Modules\ACL\Database\Seeders;

use Illuminate\Database\Seeder;

class ACLDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class]);
    }
}
