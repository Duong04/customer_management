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

Route::middleware(['auth', 'check.status'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'show'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index')->middleware('permission.action:Role Management,viewAny');
        Route::get('/create', 'create')->name('roles.create')->middleware('permission.action:Role Management,create');
        Route::post('/create', 'store')->name('roles.store')->middleware('permission.action:Role Management,create');
        Route::get('/{id}', 'show')->name('roles.show')->middleware('permission.action:Role Management,update');
        Route::put('/{id}', 'update')->name('roles.update')->middleware('permission.action:Role Management,update');
        Route::delete('/{id}', 'delete')->name('roles.delete')->middleware('permission.action:Role Management,delete');
    });

    Route::controller(ActionController::class)->prefix('actions')->group(function () {
        Route::get('/', 'index')->name('actions.index')->middleware('permission.action:Action Management,viewAny');
        Route::get('/create', 'create')->name('actions.create')->middleware('permission.action:Action Management,create');
        Route::post('/create', 'store')->name('actions.store')->middleware('permission.action:Action Management,create');
        Route::get('/{id}', 'show')->name('actions.show')->middleware('permission.action:Action Management,update');
        Route::put('/{id}', 'update')->name('actions.update')->middleware('permission.action:Action Management,update');
        Route::delete('/{id}', 'delete')->name('actions.delete')->middleware('permission.action:Action Management,delete');
    });

    Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
        Route::get('/', 'index')->name('permissions.index')->middleware('permission.action:Permission Management,viewAny');
        Route::get('/create', 'create')->name('permissions.create')->middleware('permission.action:Permission Management,create');
        Route::post('/create', 'store')->name('permissions.store')->middleware('permission.action:Permission Management,create');
        Route::get('/{id}', 'show')->name('permissions.show')->middleware('permission.action:Permission Management,update');
        Route::put('/{id}', 'update')->name('permissions.update')->middleware('permission.action:Permission Management,update');
        Route::delete('/{id}', 'delete')->name('permissions.delete')->middleware('permission.action:Permission Management,delete');
    });

    Route::controller(CustomerController::class)->prefix('customers')->group(function () {
        Route::get('/', 'index')->name('customers.index')->middleware('permission.action:Customer Management,viewAny');
        Route::get('/create', 'create')->name('customers.create')->middleware('permission.action:Customer Management,create');
        Route::post('/create', 'store')->name('customers.store')->middleware('permission.action:Customer Management,create');
        Route::get('/{id}', 'show')->name('customers.show')->middleware('permission.action:Customer Management,view');
        Route::get('/{id}/edit', 'edit')->name('customers.edit')->middleware('permission.action:Customer Management,update');
        Route::put('/{id}', 'update')->name('customers.update')->middleware('permission.action:Customer Management,update');
        Route::delete('/{id}', 'delete')->name('customers.delete')->middleware('permission.action:Customer Management,delete');
    });

    Route::controller(StaffController::class)->prefix('staffs')->group(function () {
        Route::get('/', 'index')->name('staffs.index')->middleware('permission.action:User Management,viewAny');
        Route::get('/create', 'create')->name('staffs.create')->middleware('permission.action:User Management,create');
        Route::post('/create', 'store')->name('staffs.store')->middleware('permission.action:User Management,create');
        Route::get('/{id}', 'show')->name('staffs.show')->middleware('permission.action:User Management,view');
        Route::get('/{id}/edit', 'edit')->name('staffs.edit')->middleware('permission.action:User Management,update');
        Route::put('/{id}', 'update')->name('staffs.update')->middleware('permission.action:User Management,update');
        Route::delete('/{id}', 'delete')->name('staffs.delete')->middleware('permission.action:User Management,delete');
    });

    Route::controller(ContractController::class)->prefix('contracts')->group(function () {
        Route::get('/', 'index')->name('contracts.index')->middleware('permission.action:Contract Management,viewAny');
        Route::get('/create', 'create')->name('contracts.create')->middleware('permission.action:Contract Management,create');
        Route::post('/create', 'store')->name('contracts.store')->middleware('permission.action:Contract Management,create');
        Route::get('/{id}/edit', 'edit')->name('contracts.edit')->middleware('permission.action:Contract Management,update');
        Route::get('/{id}', 'show')->name('contracts.show')->middleware('permission.action:Contract Management,view');
        Route::put('/{id}', 'update')->name('contracts.update')->middleware('permission.action:Contract Management,update');
        Route::delete('/{id}', 'delete')->name('contracts.delete')->middleware('permission.action:Contract Management,delete');
    });
});

Route::fallback(function () {
    return view('errors.404');
});