<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AnalyticsController;

Route::prefix('v1')->group(function () {

    Route::get('/test', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'API is working'
        ]);
    });

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);

    Route::get('/tags', [TagController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::post('/posts', [PostController::class, 'store']);
        Route::put('/posts/{id}', [PostController::class, 'update']);
        Route::delete('/posts/{id}', [PostController::class, 'destroy']);

        Route::post('/posts/{postId}/comments', [CommentController::class, 'store']);
        Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
        Route::post('/comments/{id}/flag', [CommentController::class, 'flag']);
        Route::post('/comments/{id}/unflag', [CommentController::class, 'unflag']);

        Route::post('/tags', [TagController::class, 'store']);
        Route::post('/posts/{postId}/tags/attach', [TagController::class, 'attach']);
        Route::post('/posts/{postId}/tags/detach', [TagController::class, 'detach']);

        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/analytics', [AnalyticsController::class, 'index']);
    });
});