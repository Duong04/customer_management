<?php

use App\Http\Controllers\Web\ActionController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ContractController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\StaffController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->middleware('guest')->prefix('/')->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/', 'handleLogin')->name('action.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'show'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index');
        Route::get('/create', 'create')->name('roles.create');
        Route::post('/create', 'store')->name('roles.store');
        Route::get('/{id}', 'show')->name('roles.show');
        Route::put('/{id}', 'update')->name('roles.update');
        Route::delete('/{id}', 'delete')->name('roles.delete');
    });

    Route::controller(ActionController::class)->prefix('actions')->group(function () {
        Route::get('/', 'index')->name('actions.index');
        Route::get('/create', 'create')->name('actions.create');
        Route::post('/create', 'store')->name('actions.store');
        Route::get('/{id}', 'show')->name('actions.show');
        Route::put('/{id}', 'update')->name('actions.update');
        Route::delete('/{id}', 'delete')->name('actions.delete');
    });

    Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
        Route::get('/', 'index')->name('permissions.index');
        Route::get('/create', 'create')->name('permissions.create');
        Route::post('/create', 'store')->name('permissions.store');
        Route::get('/{id}', 'show')->name('permissions.show');
        Route::put('/{id}', 'update')->name('permissions.update');
        Route::delete('/{id}', 'delete')->name('permissions.delete');
    });

    Route::controller(CustomerController::class)->prefix('customers')->group(function () {
        Route::get('/', 'index')->name('customers.index');
        Route::get('/create', 'create')->name('customers.create');
        Route::post('/create', 'store')->name('customers.store');
        Route::get('/{id}', 'show')->name('customers.show');
        Route::get('/{id}/edit', 'edit')->name('customers.edit');
        Route::put('/{id}', 'update')->name('customers.update');
        Route::delete('/{id}', 'delete')->name('customers.delete');
    });

    Route::controller(StaffController::class)->prefix('staffs')->group(function () {
        Route::get('/', 'index')->name('staffs.index');
        Route::get('/create', 'create')->name('staffs.create');
        Route::post('/create', 'store')->name('staffs.store');
        Route::get('/{id}', 'show')->name('staffs.show');
        Route::get('/{id}/edit', 'edit')->name('staffs.edit');
        Route::put('/{id}', 'update')->name('staffs.update');
        Route::delete('/{id}', 'delete')->name('staffs.delete');
    });

    Route::controller(ContractController::class)->prefix('contracts')->group(function () {
        Route::get('/', 'index')->name('contracts.index');
        Route::get('/create', 'create')->name('contracts.create');
        Route::post('/create', 'store')->name('contracts.store');
        Route::get('/{id}/edit', 'edit')->name('contracts.edit');
        Route::get('/{id}', 'show')->name('contracts.show');
        Route::put('/{id}', 'update')->name('contracts.update');
        Route::delete('/{id}', 'delete')->name('contracts.delete');
    });
});

Route::fallback(function () {
    return view('errors.404');
});