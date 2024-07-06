<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/blog/create', [BlogController::class, 'store']);
    Route::get('/blog/{id}', [BlogController::class, 'show']);
    Route::put('/blog/update/{id}', [BlogController::class, 'update']);
    Route::delete('/blog/delete/{id}', [BlogController::class, 'destroy']);

    Route::post('/comment/create', [CommentController::class, 'store']);
    Route::put('/comment/update/{id}', [CommentController::class, 'update']);
    Route::delete('/comment/delete/{id}', [CommentController::class, 'destroy']);

    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tag/create', [TagController::class, 'store']);
    Route::put('/tag/update/{id}', [TagController::class, 'update']);
    Route::delete('/tag/destroy/{id}', [TagController::class, 'destroy']);

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/email', [AuthController::class, 'sendPasswordResetLink']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);

Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blog/comments/{id}', [CommentController::class, 'show']);
