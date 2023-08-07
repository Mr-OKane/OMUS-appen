<?php

namespace Database\Factories;

use App\Models\PracticeDate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PracticeDate>
 */
class PracticeDateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PracticeDate::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'practice' => $this->faker->date(),
            'userID' => User::all()->random(1)[0]['id']
        ];
    }
}
