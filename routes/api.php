<?php

use App\Http\Controllers\Api\ApplicationApiController;
use App\Http\Controllers\Api\JobApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::patch('/applications/{id}/status', [ApplicationApiController::class, 'updateStatus']);
});

// Public routes (tanpa autentikasi)
Route::get('/public/jobs', [JobApiController::class, 'publicIndex']);
Route::get('/public/jobs/{job}', [JobApiController::class, 'publicShow']);

// Protected routes (dengan autentikasi)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jobs', [JobApiController::class, 'index']);
    Route::get('/jobs/{job}', [JobApiController::class, 'show']);
    Route::post('/jobs', [JobApiController::class, 'store']);
    Route::put('/jobs/{job}', [JobApiController::class, 'update']);
    Route::delete('/jobs/{job}', [JobApiController::class, 'destroy']);
});
