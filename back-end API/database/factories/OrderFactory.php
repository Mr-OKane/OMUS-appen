<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'userID' => User::all()->random(1)[0]['id'],
            'addressID' => Address::all()->random(1)[0]['id'],
            'statusID' => OrderStatus::all()->random(1)[0]['id']
        ];
    }
}
