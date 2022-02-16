<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'loan_amount' => $this->faker->randomFloat(6, 0, 100000000),
            'loan_term' => $this->faker->numberBetween(1, 50),
            'interest_rate' => $this->faker->randomFloat(6, 1, 36),
            'started_at' => $this->faker->dateTime()
        ];
    }
}
