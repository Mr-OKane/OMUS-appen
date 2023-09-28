<?php

namespace Database\Seeders;

use App\Models\CakeArrangement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CakeArrangementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CakeArrangement::factory()->count(20)->create();
    }
}
