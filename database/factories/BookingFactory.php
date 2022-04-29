<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
    public function definition()
    {
        $suffix = [
            'Villa',
            'House',
            'Cottage',
            'Luxury Villa',
            'Cheap House',
            'Rooms',
            'Cheap Rooms',
            'Luxury Rooms',
            'Fancy Rooms',
        ];
        
        return [
            'title' => $this->faker->city() . ' ' . Arr::random($suffix),
            'description' => $this->faker->paragraphs(1, true),
            'price' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
