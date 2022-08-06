<?php

namespace App\Http\Controllers\Api\v1\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingReviewResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Booking $booking
     * @return BookingReviewResource
     */
    public function __invoke(Request $request, Booking $booking): JsonResource
    {
        return BookingReviewResource::collection($booking->reviews()->latest()->get());
    }
}
