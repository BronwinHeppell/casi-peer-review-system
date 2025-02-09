<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Category::factory()->count(8)->create();

        Category::factory()->create([
            'title' => 'Culture',
            'description' => 'The culture of the company'
        ]);

        Category::factory()->create([
            'title' => 'Coding',
            'description' => 'Coding knowledge and more'
        ]);

        Category::factory()->create([
            'title' => 'Best practices',
            'description' => 'Standards, best practices, and the best way to do things'
        ]);
    }
}
