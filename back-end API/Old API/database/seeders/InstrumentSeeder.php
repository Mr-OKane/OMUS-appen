<?php

namespace Database\Seeders;

use App\Models\Instrument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instrument::factory()->count(25)->create();
    }
}
