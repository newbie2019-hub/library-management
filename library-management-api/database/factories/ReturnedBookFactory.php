<?php

namespace Database\Factories;

use App\Models\IssuedBook;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReturnedBook>
 */
class ReturnedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $issuedBook = IssuedBook::inRandomOrder()->first();

        return [
            'issued_book_id' => $issuedBook,
            'fine' => 0,
            'returned_at' => $issuedBook->return_date->subDays(2),
            'quantity' => $issuedBook->quantity,
            'remarks' => 'All books have been returned'
        ];
    }
}
