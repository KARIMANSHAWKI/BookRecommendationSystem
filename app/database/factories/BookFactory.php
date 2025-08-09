<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(20),
            'description' => Str::random(100),
            'number_of_pages' => rand(1,100),
            'cover' => null,
            'section_id' => null,
            'created_by' => null,
        ];
    }
}
