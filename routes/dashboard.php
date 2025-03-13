<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;


Route::prefix('dashboard_v2')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard_v2');
    Route::middleware('role:' . RoleEnum::ADMIN->value)->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('dashboard_v2_users');
            Route::get('/users/create', 'create')->name('dashboard_v2_user_create');
            Route::get('/users/edit/{uuid}', 'edit')->name('dashboard_v2_user_edit');
        });
        Route::controller(ClientController::class)->group(function (){
            Route::get('/clients', 'index')->name('dashboard_v2_clients');
            Route::get('/clients/create', 'create')->name('dashboard_v2_client_create');
            Route::get('/clients/edit/{uuid}', 'edit')->name('dashboard_v2_client_edit');
        });
    });
});
