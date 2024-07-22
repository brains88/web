<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\{WebsiteController, CategoryController, VoteController,};
use App\Http\Controllers\auth\AuthController;

// Routes for Unauthenticated Users
Route::get('/websites', [WebsiteController::class, 'index']);
Route::get('/websites/search', [WebsiteController::class, 'search']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes for Authenticated Users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/websites', [WebsiteController::class, 'store']);
    //Route for website deletion by the admin
    Route::delete('/websites/{id}', [WebsiteController::class, 'destroy'])->middleware('admin');
    
    Route::post('/logout', [AuthController::class, 'logout']);
    //Routes for voting and removing vote
    Route::post('/votes', [VoteController::class, 'store']);
    Route::delete('/votes/{id}', [VoteController::class, 'destroy']); 
});
