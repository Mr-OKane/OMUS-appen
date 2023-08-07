<?php

namespace Database\Factories;

use App\Models\PostalCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostalCode>
 */
class PostalCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostalCode::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'postalCode' => $this->faker->postcode(),
            'city' => $this->faker->city()
        ];
    }
}
