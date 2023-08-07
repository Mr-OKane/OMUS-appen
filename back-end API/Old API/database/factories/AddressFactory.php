<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\PostalCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'line1' => $this->faker->address(),
            'line2' => "",
            'postalCode' => PostalCode::all()->random(1)[0]['postalCode']

        ];
    }
}
