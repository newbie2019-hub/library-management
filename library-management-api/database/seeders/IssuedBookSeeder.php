<?php

namespace Database\Seeders;

use App\Models\IssuedBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssuedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IssuedBook::factory(30)->create();
    }
}
