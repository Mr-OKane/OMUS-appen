<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProducts>
 */
class OrderProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProducts::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'productID' => Product::all()->random(1)[0]['id'],
            'orderID' => Order::all()->random(1)[0]['id'],
            'price' => $this->faker->randomFloat(2,1,999999)
        ];
    }
}
