<?php

namespace Database\Seeders;

use App\Models\CakeArrengement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CakeArrengementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CakeArrengement::factory()->count(20)->create();
    }
}
