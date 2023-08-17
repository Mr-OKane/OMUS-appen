<?php

namespace Database\Seeders;

use App\Models\PracticeDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PracticeDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PracticeDate::factory()->count(50)->create();
    }
}
