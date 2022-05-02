<?php

use App\Http\Controllers\Api\v1\BookingAvailabilityController;
use App\Http\Controllers\Api\v1\BookingController;
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
});
