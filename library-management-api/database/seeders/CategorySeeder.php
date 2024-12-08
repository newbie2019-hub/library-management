<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Horror',
            'Romance Novel',
            'Young Adult',
            'Autobiography',
            'Science Fiction',
            'Fantasy',
            'Adventure Fiction',
            'Mystery',
            'Thriller',
            'Fairy Tale',
            'Short Story',
            'Suspense',
            'Biographies',
            'Drama',
            'Fiction',
            'Action',
            'Children Story',
            'Picture',
            'Board',
            'Adventure'
        ];

        foreach ($categories as $category) {
            Category::create([
                'category' => $category
            ]);
        }
    }
}
