<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Caravan>
 */
class CaravanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => rand(1, 10),
            'location' => $this->faker->city,
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'price' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
