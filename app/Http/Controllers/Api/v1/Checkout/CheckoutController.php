<?php

namespace App\Http\Controllers\Api\v1\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Address;
use App\Models\Booking;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(CheckoutRequest $request)
    {
        $validated = $request->validated();

        $reservationsData = $validated['reservations'];

        $reservations = collect($reservationsData)->map(function ($reservationData) use ($validated) {
            $booking = Booking::findOrFail($reservationData['booking_id']);
            $reservation= new Reservation();
            $reservation->from = $reservationData['from'];
            $reservation->to = $reservationData['to'];
            $reservation->booking()->associate($booking);
            $reservation->price = $booking->priceFor($reservation->from, $reservation->to)['total'];
            $reservation->address()->associate($validated['address_id']);

            $reservation->save();

            return $reservation;
        });

        return $reservations;
    }
}
