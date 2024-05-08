<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::controller(\App\Http\Controllers\AirportController::class)->group(function() {
    Route::get('/airports', 'index');
    Route::get('/airport-deleted', 'airports_deleted');
    Route::post('/view_ce_airport', 'view_ce_airport');
    Route::post('/get-airports', 'get_airports');
    Route::post('/airport-edit', 'ce_airport');
    Route::post('/airport-delete', 'delete_airport');
    Route::post('/airport-restore', 'restore_airport');
});
Route::controller(\App\Http\Controllers\AirlineController::class)->group(function() {
    Route::get('/airlines', 'index');
    Route::get('/airline-deleted', 'airlines_deleted');
    Route::post('/view_ce_airline', 'view_ce_airline');
    Route::post('/get-airlines', 'get_airlines');
    Route::post('/airline-edit', 'ce_airline');
    Route::post('/airline-delete', 'delete_airline');
    Route::post('/airline-restore', 'restore_airline');
});

Route::controller(\App\Http\Controllers\AirplaneController::class)->group(function() {
    Route::get('/airplanes', 'index');
    Route::get('/airplane-deleted', 'airplanes_deleted');
    Route::post('/view_ce_airplane', 'view_ce_airplane');
    Route::post('/get-airplanes', 'get_airplanes');
    Route::post('/airplane-edit', 'ce_airplane');
    Route::post('/airplane-delete', 'delete_airplane');
    Route::post('/airplane-restore', 'restore_airplane');
});
Route::controller(\App\Http\Controllers\FlightController::class)->group(function() {
    Route::get('/flights', 'index');
    Route::get('/flight-deleted', 'flights_deleted');
    Route::post('/view_ce_flight', 'view_ce_flight');
    Route::post('/get-flights', 'get_flights');
    Route::post('/flight-edit', 'ce_flight');
    Route::post('/flight-delete', 'delete_flight');
    Route::post('/flight-restore', 'restore_flight');
});
