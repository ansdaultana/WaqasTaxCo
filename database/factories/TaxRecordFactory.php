<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaxRecord>
 */
class TaxRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->year,
            'min_income' => $this->faker->randomFloat(2, 10000, 50000),
            'max_income' => $this->faker->optional()->randomFloat(2, 50001, 100000),
            'rate' => $this->faker->randomFloat(2, 5, 30),
            'fixed_amount' => $this->faker->optional()->randomFloat(2, 1000, 10000),
        ];
    }
}
