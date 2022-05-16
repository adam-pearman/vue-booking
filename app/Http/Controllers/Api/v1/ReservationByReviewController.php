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
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request, $reviewKey): AnonymousResourceCollection
    {
        return ReservationByReviewShowResource::collection(Reservation::findByReviewKey($reviewKey)) ?? abort(404);
    }
}
