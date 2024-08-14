<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(11, 20),
            'caravan_id' => rand(1, 11),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_date' => $this->faker->dateTimeBetween('+1 year', '+2 year'),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'cash']),
            'payment_status' => $this->faker->randomElement(['paid', 'pending', 'failed']),

            //
        ];
    }
}
