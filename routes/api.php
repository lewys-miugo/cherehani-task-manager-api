<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class)
        ->except(['index', 'show']);
});

Route::apiResource('tasks', TaskController::class)
    ->only(['index', 'show']);