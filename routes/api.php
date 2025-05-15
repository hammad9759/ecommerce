<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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



Route::match(['GET', 'POST'], '/auth/register', [AuthController::class, 'register'])->name('userRegister');
Route::match(['GET', 'POST'], '/auth/login', [AuthController::class, 'login'])->name('userLogin');

// Route::middleware('auth:sanctum')->post('/showUser', function (Request $request) {
//     return $request->user();
// });

// In routes/api.php
Route::post('/user/showUser', [AuthController::class, 'showUser'])->middleware('auth:sanctum');
Route::post('/user/update', [AuthController::class, 'updateUser'])->middleware('auth:sanctum');
Route::post('/user/logout', [AuthController::class, 'apiUserLogout'])->middleware('auth:sanctum');

