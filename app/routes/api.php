<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::name('auth.')->prefix('auth')->controller(AuthController::class)->group(function (){
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
});

Route::name('books.')->prefix('books')->controller(BookController::class)->group(function (){
    Route::middleware(['auth:sanctum'])->post('/submit-interval', 'submitUserReadingInterval')->name('submit-interval');
    Route::get('/get-recommended-books', 'getMostRecommendedFiveBooks')->name('get-recommended-books');
});
