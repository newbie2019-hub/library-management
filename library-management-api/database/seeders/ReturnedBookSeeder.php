<?php

namespace Database\Seeders;

use App\Models\ReturnedBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReturnedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReturnedBook::factory(30)->create();
    }
}
