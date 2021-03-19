<?php

use Illuminate\Support\Facades\Route;
use Tipoff\Http\Resources\ReviewResource;
use Tipoff\Locations\Models\Location;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/location/{$location}/reviews', function ($location) {
    // Location uses slug as route key name
    $location = Location::where('slug', $location)->first();

    return ReviewResource::collection($location->reviews);
});