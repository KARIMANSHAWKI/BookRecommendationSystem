<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SectionManagementController;
use App\Http\Controllers\UserController;
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


Route::name('auth.')->prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
});

Route::name('books.')->prefix('books')->controller(BookController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{book}', 'show')->name('show');
    Route::get('/get-recommended-books', 'getMostRecommendedFiveBooks')->name('get-recommended-books');
    Route::get('/google/search/{search_key}', 'searchInGoogleBooks')->name('google.search');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/', BookController::class)->except(['create','edit','index','show']);
        Route::post('/submit-interval', 'submitUserReadingInterval')->name('submit-interval');
        Route::patch('{book}/section', 'assignSection')
            ->name('assign-section');
    });
});

Route::middleware(['auth:sanctum', 'can:manage-users'])->group(function () {
    Route::apiResource('users', UserController::class);
});
Route::middleware(['auth:sanctum'])->group(function (){
    Route::apiResource('sections', SectionManagementController::class);
});


