<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\PossibleDuplicateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// auth routes
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // admin routes
    Route::group(['middleware' => ['administrate']], function () {
        Route::resource('images', ImageController::class);

        Route::put('/possible_duplicates/{possibleDuplicate}/ignore', [PossibleDuplicateController::class, 'ignore'])->name('possible_duplicates.ignore');
        Route::put('/possible_duplicates/{possibleDuplicate}/{image}', [PossibleDuplicateController::class, 'keepImage'])->name('possible_duplicates.keep_image');
        Route::resource('possible_duplicates', PossibleDuplicateController::class)->only(['index', 'show', 'destroy']);
    });
});
