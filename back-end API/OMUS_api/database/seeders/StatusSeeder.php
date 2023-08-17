<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Order confirmed'],
            ['name' => 'Order pending'],
            ['name' => 'Order shipped'],
            ['name' => 'Order arrived'],
            ['name' => 'Order received'],
            ['name' => 'User inactive'],
            ['name' => 'User active'],
        ];

        foreach ($statuses as $status)
        {
            Status::firstOrCreate($status);
        }
    }
}
