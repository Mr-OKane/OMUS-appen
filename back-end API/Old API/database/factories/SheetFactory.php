<?php

namespace Database\Factories;

use App\Models\Sheet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sheet>
 */
class SheetFactory extends Factory
{
    /**
     *
     *
     * @return string
     */
    protected $model = Sheet::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'node' => realpath($_SERVER["DOCUMENT_ROOT"])."/public/pdf/upload".$this->faker->unique()->word().".pdf"
        ];
    }
}
