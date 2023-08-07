<?php

namespace Database\Factories;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Absence::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'absence' => $this->faker->boolean(),
            'date' => $this->faker->date(),
            'userID' => User::all()->random(1)[0]['id']
        ];
    }
}
