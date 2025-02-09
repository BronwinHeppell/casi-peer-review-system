<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@casi.com',
            'password' => 'password',
            'is_admin' => true,
            'role' => 'Manager'
        ]);

        $this->call([
            CategorySeeder::class,
        ]);
    }
}
