<?php

namespace Database\Factories;

use App\Models\Address;
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
        $arrayValues = ['pending','accepted','processing','dispatched','delivered'];

        return [
            'address_id' => Address::all()->random(1)[0]['id'],
            'status' => $arrayValues[rand(0,4)],
            'user_id' => User::all()->random(1)[0]['id'],
            'order_date' => $this->faker->dateTime(),
        ];
    }
}
