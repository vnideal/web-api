<?php

use App\Http\Controllers\Auth\AuthController;
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

Route::get('/', function () {
    return response()->json(['message' => 'Hello world']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::put('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('profile', [AuthController::class, 'user'])->name('profile');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
