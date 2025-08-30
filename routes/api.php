<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TransfersController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);



Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/create', [UserController::class, 'store']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::get('/delete/{id}', [UserController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'account'
    ], function () {
        Route::post('/store', [AccountController::class, 'store']);
        Route::post('/deactive', [AccountController::class, 'alterStatus']);
    });

    Route::group([
        'prefix' => 'transfers'
    ], function () {
        Route::post('/', [TransfersController::class, 'store']);
    });
});
