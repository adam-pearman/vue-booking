<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationByReviewShowResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param $reviewKey
     * @return ReservationByReviewShowResource
     */
    public function __invoke(Request $request, $reviewKey): ReservationByReviewShowResource
    {
        $reservation = Reservation::findByReviewKey($reviewKey);
        return $reservation ? new ReservationByReviewShowResource($reservation) : abort(404);
    }
}
