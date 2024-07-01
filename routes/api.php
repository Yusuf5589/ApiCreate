<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register', [LoginController::class, "userAdd"]);

Route::post('/login', [LoginController::class, "login"]);


Route::fallback(function () {
    return response()->json(['message' => 'Token yok'], 401);
});




Route::middleware("auth:sanctum")->group(function () {
    Route::get('/list', [LoginController::class, "userGet"]);
    Route::get('/get/{id}', [LoginController::class, "firstGet"]);
});

