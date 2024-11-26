<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory(200)
            ->create()
            ->each(function ($book) {
               $randomCategories = Category::inRandomOrder()
                    ->take(8)
                    ->pluck('id')
                    ->toArray();

                $book->categories()->attach($randomCategories);
            });
    }
}
