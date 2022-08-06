<?php

namespace App\Http\Controllers\Api\v1\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingPriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request, Booking $booking): JsonResponse
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        return response()->json([
            'data' => $booking->priceFor($data['from'], $data['to'])
        ]);
    }
}
