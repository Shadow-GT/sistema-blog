<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes
Route::get('/search/suggestions', [SearchController::class, 'suggestions']);
Route::get('/search/popular', [SearchController::class, 'popular']);

// API pública v1 de posts (solo lectura, solo publicados). Rate-limit del grupo 'api'.
Route::prefix('v1')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('/posts/latest', [PostController::class, 'latest'])->name('api.posts.latest');
});
