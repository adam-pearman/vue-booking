<?php

namespace App\Http\Controllers\Api\v1\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\PaymentIntentRequest;
use App\Models\Address;
use App\Models\Booking;
use Symfony\Component\HttpFoundation\Response;

class PaymentIntentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PaymentIntentRequest $request)
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

        $totalPrice = 0;

        collect($reservationsData)->map(function ($reservationData) use (&$totalPrice) {
            $booking = Booking::findOrFail($reservationData['booking_id']);
            $totalPrice += $booking->priceFor($reservationData['from'], $reservationData['to'])['total'] * 100;
        });

        $paymentIntent = $request->user()->pay(
            $totalPrice
        );
        
        $address = Address::firstOrCreate($addressData);

        return response()->json(
            ['data' => [
                'paymentIntentClientSecret' => $paymentIntent->client_secret,
                'address_id' => $address->id,
            ]],
            Response::HTTP_CREATED
        );
    }
}
