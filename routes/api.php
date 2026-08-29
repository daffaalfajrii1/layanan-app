<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ServiceController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'username' => $request->user()->username,
            'email' => $request->user()->email,
        ];
    });

    Route::middleware('abilities:services:read')->group(function () {
        Route::get('/services', [ServiceController::class, 'index']);
        Route::get('/services/{service:slug}', [ServiceController::class, 'show']);
    });

    Route::post('/services/{service:slug}/registrations', [RegistrationController::class, 'store'])
        ->middleware('abilities:registrations:create');

    Route::get('/registrations/{registration:registration_number}', [RegistrationController::class, 'show'])
        ->middleware('abilities:registrations:read');
});
