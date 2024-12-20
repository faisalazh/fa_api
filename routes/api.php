<?php

use App\Http\Controllers\UserController;

Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);

