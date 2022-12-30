<?php

use App\Http\Controllers\Api\Client\AttendanceController;
use App\Http\Controllers\Api\NotifyController;
use App\Http\Controllers\Api\UserController;
use App\Services\NotifyService;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'attendances'], function () {
        Route::get('/', [AttendanceController::class, 'index']);
        Route::get('/{user}', [AttendanceController::class, 'getAttendanceByUser']);
        Route::post('/', [AttendanceController::class, 'store']);
        Route::post('/update', [AttendanceController::class, 'update']);
        Route::put('/checkout', [AttendanceController::class, 'checkOut']);
    });
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::delete('/{user}', [UserController::class, 'delete']);
        Route::put('/{user}', [UserController::class, 'update']);
    });
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/get-list', [NotifyController::class, 'index']);
        Route::put('/update-read/{message}', [NotifyController::class, 'updateRead']);
        Route::post('/', [NotifyController::class, 'store']);
    });
});
