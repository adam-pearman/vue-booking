<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Reservation;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Booking::all()->each(function (Booking $booking) use ($faker) {
            $reservation = Reservation::factory()->make();
            $reservations = collect([$reservation]);

            for ($i = 0; $i < random_int(1,20); $i++) {
                $from = (clone $reservation->to)->addDays(random_int(1, 14));
                $to = (clone $from)->addDays(random_int(0, 14));

                $reservation = Reservation::make([
                    'from' => $from,
                    'to' => $to,
                    'price' => $faker->numberBetween(1000, 5000),
                ]);
                $reservations->push($reservation);
            }
            $booking->reservations()->saveMany($reservations);
        });
    }
}
