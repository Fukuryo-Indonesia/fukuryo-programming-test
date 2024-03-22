<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Category::insert([
            [
                'name'  =>  Str::upper('Non-fiction'),
                'slug'  =>  'non-fiction',
                'description'   =>  Str::title('Non-fiction Category')
            ],
            [
                'name'  =>  Str::upper('Encyclopedia'),
                'slug'  =>  'encyclopedia',
                'description'   =>  Str::title('Encyclopedia Category')
            ],
            [
                'name'  =>  Str::upper('Biography'),
                'slug'  =>  'biography',
                'description'   =>  Str::title('Biography Category')
            ],
            [
                'name'  =>  Str::upper('Anthology'),
                'slug'  =>  'anthology',
                'description'   =>  Str::title('Anthology Category')
            ],
            [
                'name'  =>  Str::upper('Fantasy'),
                'slug'  =>  'fantasy',
                'description'   =>  Str::title('Fantasy Category')
            ],
        ]);

        Author::factory(10)->create();
    }
}
