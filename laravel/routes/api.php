<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/user/{id}', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get/patients', [PatientController::class, 'index']);
    Route::put('/update/patients/{id}', [PatientController::class, 'update']);
    Route::delete('/delete/patients/{id}', [PatientController::class, 'destroy']);
});




