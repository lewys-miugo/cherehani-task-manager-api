<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'tasks.index');
Route::view('/tasks', 'tasks.index');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register');

Route::post('/logout', function () {
    // Handle via JS
})->middleware('auth:sanctum');
