<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\Auth\LoginRegisterController;
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

// Public routes of authtication
Route::controller(LoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Public routes of product
Route::controller(MobileController::class)->group(function() {
    Route::get('/mobiles', 'index');
    Route::get('/mobiles/{id}', 'show');
    Route::get('/mobiles/search/{name}', 'search');
});

// Protected routes of product and logout
Route::middleware('auth:api')->group( function () {
    Route::post('/logout', [LoginRegisterController::class, 'logout']);

    Route::controller(MobileController::class)->group(function() {
        Route::post('/mobiles', 'store');
        Route::post('/mobiles/{id}', 'update');
        Route::delete('/mobiles/{id}', 'destroy');
    });
});