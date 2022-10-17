<?php

namespace Database\Seeders;

use App\Models\Sheet;
use Database\Factories\SheetFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sheet::factory()->count(5)->create();
    }
}
