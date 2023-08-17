<?php

namespace Database\Seeders;

use App\Models\Sheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sheet::factory()->count(20)->create();
    }
}
