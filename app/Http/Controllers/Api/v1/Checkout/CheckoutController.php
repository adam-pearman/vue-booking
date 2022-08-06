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
        $validated = array_merge($validated, $request->validate([
            'reservations.*' => ['required', function ($attribute, $value, $fail) {
                $booking = Booking::findOrFail($value['booking_id']);

                if (!$booking->availableFor($value['from'], $value['to'])) {
                    $fail('This booking is not available on the given dates');
                }
            }],
        ]));

        $reservationsData = $validated['reservations'];
        $addressData = $validated['customer'];

        $reservations = collect($reservationsData)->map(function ($reservationData) use ($addressData) {
            $reservation= new Reservation();
            $reservation->from = $reservationData['from'];
            $reservation->to = $reservationData['to'];
            $reservation->booking_id = $reservationData['booking_id'];
            $reservation->price = 2000;
            $reservation->address()->associate(Address::create($addressData));

            $reservation->save();

            return $reservation;
        });

        return $reservations;
    }
}
