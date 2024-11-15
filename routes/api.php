<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
Route::get('/alumni', [AlumniController::class, 'index']);
Route::post('/alumni', [AlumniController::class, 'store']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::put('/alumni/{id}', [AlumniController::class, 'update']);
Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);
Route::get('/alumni/search/{name}', [AlumniController::class, 'search']);
Route::get('/alumni/status/fresh-graduate', [AlumniController::class, 'freshGraduate']);
Route::get('/alumni/status/employed', [AlumniController::class, 'employed']);
Route::get('/alumni/status/unemployed', [AlumniController::class, 'unemployed']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);