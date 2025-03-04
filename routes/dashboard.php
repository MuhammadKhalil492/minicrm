<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('dashboard_v2')->group(function(){
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard_v2');
 Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('dashboard_v2_users');
        Route::get('/users/create', 'create')->name('dashboard_v2_user_create');
        Route::get('/users/edit/{uuid}', 'edit')->name('dashboard_v2_user_edit');
    });
});
