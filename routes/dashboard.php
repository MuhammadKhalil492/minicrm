<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard_v2', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
});
