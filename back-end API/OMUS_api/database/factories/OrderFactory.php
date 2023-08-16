<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address_id' => Address::all()->random(1)[0]['id'],
            'status_id' => Status::all()->random(1)[0]['id'],
            'user_id' => User::all()->random(1)[0]['id'],
            'order_date' => $this->faker->dateTime(),
        ];
    }
}
