<?php


use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/getstoreinfo/{store_id}', ApiController::class, 'getstoreinfo');

// Route::get('/test', function () {
//     return 'test';
// });
