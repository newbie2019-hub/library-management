<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IssuedBook>
 */
class IssuedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => User::inRandomOrder()->first(),
            'member_id' => User::inRandomOrder()->first(),
            'book_id' => Book::inRandomOrder()->first(),
            'issued_at' => fake()->iso8601(),
            'quantity' => 5
        ];
    }
}
