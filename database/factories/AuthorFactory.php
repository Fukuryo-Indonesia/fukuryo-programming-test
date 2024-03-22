<?php

namespace Database\Factories;

use App\Models\Author;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        return [
            'name'  =>  $name,
            'slug'  =>  SlugService::createSlug(Author::class, 'slug', $name),
            'dob'   =>  fake()->dateTimeBetween('1964-01-01', '1990-12-31')->format('Y-m-d'),
            'address'   =>  fake()->address(),
        ];
    }
}
