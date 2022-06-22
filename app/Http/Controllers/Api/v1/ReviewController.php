<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }
//
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ReviewResource
     */
    public function store(Request $request): ReviewResource
    {
        $data = $request->validate([
            'id' => 'required|size:36|unique:reviews',
            'content' => 'required|min:2',
            'rating' => 'required|in:1,2,3,4,5'
        ]);

        $reservation = Reservation::findByReviewKey($data['id']);

        if ($reservation === null) {
            return abort(404);
        }

        $reservation->review_key = '';
        $reservation->save();

        $review = Review::make($data);
        $review->reservation_id = $reservation->id;
        $review->booking_id = $reservation->booking_id;
        $review->save();

        return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @return ReviewResource
     */
    public function show(Review $review): ReviewResource
    {
        return new ReviewResource($review);
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Models\Review  $review
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, Review $review)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Models\Review  $review
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(Review $review)
//    {
//        //
//    }
}
