<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthenticateController::class, 'store']);
Route::apiResource('/users', UserController::class)->only(['index', 'show'])->middleware(['auth:sanctum']);
