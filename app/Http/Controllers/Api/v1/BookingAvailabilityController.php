<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Booking $booking
     * @return JsonResponse
     */
    public function __invoke(Request $request, Booking $booking): JsonResponse
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        return $booking->availableFor($data['from'], $data['to'])
            ? response()->json([])
            : response()->json([], 404);
    }
}
