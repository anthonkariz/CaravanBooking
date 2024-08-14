<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

// Route::get('/user', function (Request $request) {
//     return $request->user();

// })->middleware('auth:sanctum');


Route::get('/authenticate', 'App\Http\Controllers\Api\Authenticate@index');
Route::post('/register', 'App\Http\Controllers\Api\Authenticate@register');
Route::post('/login', 'App\Http\Controllers\Api\Authenticate@login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users', 'App\Http\Controllers\Api\Users@index');
    Route::get('/users/{id}', 'App\Http\Controllers\Api\Users@show');
    Route::PATCH('/updateuser/{id}', 'App\Http\Controllers\Api\Users@update');
    Route::PATCH('/updatepassword/{id}', 'App\Http\Controllers\Api\Users@updatePassword');

    Route::get('/caravans', 'App\Http\Controllers\Api\Caravan@index');
    Route::post('/caravan/add', 'App\Http\Controllers\Api\Caravan@addCaravan');
    Route::delete('/caravans/delete/{id}', 'App\Http\Controllers\Api\Caravan@destroy');
    Route::get('/caravans/{id}', 'App\Http\Controllers\Api\Caravan@show');
    Route::patch('/caravans/update/{id}', 'App\Http\Controllers\Api\Caravan@update');

    Route::get('/bookings', 'App\Http\Controllers\Api\Booking@index');
    Route::get('/bookings/{id}', 'App\Http\Controllers\Api\Booking@show');
    Route::get('/bookings/caravan/{id}', 'App\Http\Controllers\Api\Booking@bookingByCaravan');
    Route::get('/bookings/user/{id}', 'App\Http\Controllers\Api\Booking@bookingByUser');
    Route::get('/bookings/status/{status}', 'App\Http\Controllers\Api\Booking@bookingByStatus');
    Route::get('/bookings/paymentstatus/{status}', 'App\Http\Controllers\Api\Booking@bookingByPaymentStatus');
    Route::post('/booking/add', 'App\Http\Controllers\Api\Booking@store');
    Route::PATCH('/booking/update/{id}', 'App\Http\Controllers\Api\Booking@update');
    Route::delete('/booking/delete/{id}', 'App\Http\Controllers\Api\Booking@destroy');
    Route::post('/availability', 'App\Http\Controllers\Api\Booking@bookingByDate');
});
