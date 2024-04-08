<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/pokemon', [PokemonController::class, 'index']);
Route::get ('/pokemon/{id}', [PokemonController::class, 'show']); 

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/pokemon', [PokemonController::class, 'store']);
    Route::put('/pokemon/{id}', [PokemonController::class, 'update']);
    Route::delete('/pokemon/{id}', [PokemonController::class, 'destroy']);
});




