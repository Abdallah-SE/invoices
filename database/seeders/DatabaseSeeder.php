<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use  Database\Seeders\CreateAdminUserSeeder;
use  Database\Seeders\PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
    }
}
