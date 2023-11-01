<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PracticeDate>
 */
class PracticeDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = Carbon::now()->year;
        $startDate = Carbon::createFromDate($year,7,1,'Europe/Copenhagen');
        $endDate = Carbon::createFromDate($year+1,6,31,'Europe/Copenhagen');

        $min = strtotime($startDate);
        $max = strtotime($endDate);
        $randomDate = mt_rand($min,$max);
        return [
            'practice_date' => date('Y-m-d H:i:s',$randomDate),
        ];
    }
}
