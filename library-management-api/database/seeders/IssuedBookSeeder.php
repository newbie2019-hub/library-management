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
        IssuedBook::factory(40)->create();
        IssuedBook::factory(4)->create([
            'issued_at' => now()->subWeek(),
            'return_date' => now()->subDays(1)
        ]);
    }
}
