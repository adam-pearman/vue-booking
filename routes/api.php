<?php

use App\Http\Controllers\Api\v1\Checkout\CheckoutController;
use App\Http\Controllers\Api\v1\Booking\BookingAvailabilityController;
use App\Http\Controllers\Api\v1\Booking\BookingController;
use App\Http\Controllers\Api\v1\Booking\BookingPriceController;
use App\Http\Controllers\Api\v1\Booking\BookingReviewController;
use App\Http\Controllers\Api\v1\Reservation\ReservationByReviewController;
use App\Http\Controllers\Api\v1\Review\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('bookings', BookingController::class)->only(['index', 'show']);
    Route::get('/bookings/{booking}/availability', BookingAvailabilityController::class)
        ->name('bookings.availability.show');
    Route::get('/bookings/{booking}/reviews', BookingReviewController::class)
        ->name('bookings.reviews.index');
    Route::get('/bookings/{booking}/price', BookingPriceController::class)
        ->name('bookings.price.show');

    Route::get('/reservation-by-review/{reviewKey}', ReservationByReviewController::class)
        ->name('reservation.by-review.show');

    Route::apiResource('reviews', ReviewController::class)->only(['store', 'show']);

    Route::post('checkout', CheckoutController::class)->name('checkout');
});
