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
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::put('user/update-profile', [AuthController::class, 'updateProfile']);
    Route::get('user', [AuthController::class, 'user']);
    Route::get('logout', [AuthController::class, 'logout']);
});
