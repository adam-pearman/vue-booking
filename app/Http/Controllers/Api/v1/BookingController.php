<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return BookingResource::collection(Booking::all());
    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param Request $request
//     * @return BookingResource
//     */
//    public function store(Request $request): BookingResource
//    {
//        //
//    }

    /**
     * Display the specified resource.
     *
     * @param Booking $booking
     * @return BookingResource
     */
    public function show(Booking $booking): BookingResource
    {
        return new BookingResource($booking);
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param Request $request
//     * @param Booking $booking
//     * @return BookingResource
//     */
//    public function update(Request $request, Booking $booking): BookingResource
//    {
//        //
//    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param Booking $booking
//     * @return JsonResponse
//     */
//    public function destroy(Booking $booking): JsonResponse
//    {
//        //
//    }
}
