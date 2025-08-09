<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookManagementController;
use App\Http\Controllers\SectionManagementController;

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
//    Route::middleware('auth:sanctum')->apiResource('/', BookManagementController::class)
//        ->parameters(['' => 'book'])
//        ->except(['create','edit'])
//        ->names([
//            'index'   => 'index',
//            'store'   => 'store',
//            'show'    => 'show',
//            'update'  => 'update',
//            'destroy' => 'destroy',
//        ]);
});

    Route::middleware('auth:sanctum')
        ->name('book_mgmt.')
        ->controller(BookManagementController::class)
        ->group(function () {
            Route::apiResource('books', BookManagementController::class)
                ->except(['create','edit']);
            Route::patch('books/{book}/section', 'assignSection')->name('books.assign-section');
        });
    // This gives you:
    //   GET    /api/books
    //   POST   /api/books
    //   GET    /api/books/{book}
    //   PUT    /api/books/{book}
    //   PATCH  /api/books/{book}
    //   DELETE /api/books/{book}


Route::name('users.')->prefix('users')->controller(UserController::class)
    ->middleware('auth:sanctum')  // already in controller, but you can also group here
    ->group(function () {
        Route::get('/',       'index')->name('index');
        Route::post('/',      'store')->name('store');
        Route::get('/{user}', 'show')->name('show');
        Route::patch('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
});

Route::apiResource('sections', SectionManagementController::class);


