<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderStatuses = [
            ['type' => 'payment pending'],
            ['type' => 'payment accepted'],
            ['type' => 'processing'],
            ['type' => 'dispatched'],
            ['type' => 'delivered']
        ];
        foreach ($orderStatuses as $orderStatus){
            OrderStatus::firstOrCreate($orderStatus);
        }
    }
}
