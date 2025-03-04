<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function ()
{
    Route::post('register', [ AuthController::class, 'register']);
    Route::post('login', [ AuthController::class, 'login']);
});

Route::prefix('/users')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/', [UserController::class, 'getUsers']);
});


// Route::get('/users', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
