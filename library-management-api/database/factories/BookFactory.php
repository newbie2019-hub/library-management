<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'author_id' => Author::factory()->create(),
            'isbn_no' => fake()->ean13(),
            'title' => fake()->sentence(4),
            'quantity' => fake()->numberBetween(10, 50),
            'price' => fake()->randomNumber(4),
            'pages' => fake()->numberBetween(40, 300)
        ];
    }
}
