<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $from = Carbon::instance($this->faker->dateTimeBetween('-1 month', '+1 month'));
        $to = (clone $from)->addDays(random_int(0, 14));
        return [
            'from' => $from,
            'to' => $to,
        ];
    }
}
