<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\RecordsController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/user/{id}', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get/patients', [PatientController::class, 'index']);
    Route::put('/update/patients/{id}', [PatientController::class, 'update']);
    Route::delete('/delete/patients/{id}', [PatientController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get/doctors', [DoctorController::class, 'index']);
    Route::post('/create/doctors', [DoctorController::class, 'store']);
    Route::put('/update/doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('/delete/doctors/{id}', [DoctorController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get/appointments', [AppointmentController::class, 'index']);
    Route::get('/get/my-appointments', [AppointmentController::class, 'getOwnAppointments']);
    Route::post('/book/appointments', [AppointmentController::class, 'store']);
    Route::post('/finish/appointment/{id}', [AppointmentController::class, 'finishAppointment']);
    Route::delete('/delete/appointments/{id}', [AppointmentController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get/records', [RecordsController::class, 'index']);
    Route::get('/get/my-records', [RecordsController::class, 'getOwnRecords']);
    Route::put('/update/records/{id}', [RecordsController::class, 'update']);

});










