<?php

namespace Database\Seeders;

use App\Models\PracticeDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PracticeDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PracticeDate::factory()->count(33)->create();
    }
}
