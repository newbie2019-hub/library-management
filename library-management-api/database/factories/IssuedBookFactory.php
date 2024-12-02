<?php

namespace Database\Factories;

use App\Enums\book\DurationType;
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
        $days = fake()->numberBetween(1, 5);

        return [
            'user_id' => User::inRandomOrder()->first(),
            'member_id' => User::inRandomOrder()->first(),
            'book_id' => Book::inRandomOrder()->first(),
            'issued_at' => now()->subDays($days),
            'quantity' => fake()->numberBetween(1, 6),
            'return_date' => now()->addDays($days),
        ];
    }
}
