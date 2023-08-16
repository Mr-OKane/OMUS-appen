<?php

namespace Database\Factories;

use App\Models\PracticeDate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CakeArrengement>
 */
class CakeArrengementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'practice_date_id' => PracticeDate::all()->random('1')[0]['id'],
            'user_id' => User::all()->random(1)[0]['id'],
        ];
    }
}
