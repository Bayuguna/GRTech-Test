<?php

use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Setting\AccessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setting\CurrencyController;
use App\Http\Controllers\Setting\RoleController;

Route::prefix('settings')->group(function () {
    // Access
    Route::get('/accesses', [AccessController::class, 'index'])->name('setting.access.index')->middleware('can:access:view');
    Route::get('/accesses/data', [AccessController::class, 'data'])->name('setting.access.data');
    Route::get('/accesses/create', [AccessController::class, 'create'])->name('setting.access.create');
    Route::get('/accesses/show/{uuid}', [AccessController::class, 'show'])->name('setting.access.show');
    Route::post('/accesses/store', [AccessController::class, 'store'])->name('setting.access.store');
    Route::get('/accesses/edit/{uuid}', [AccessController::class, 'edit'])->name('setting.access.edit');
    Route::put('/accesses/update/{uuid}', [AccessController::class, 'update'])->name('setting.access.update');
    Route::delete('/accesses/delete/{uuid}', [AccessController::class, 'destroy'])->name('setting.access.delete');

    // Role
    Route::get('/roles', [RoleController::class, 'index'])->name('setting.role.index')->middleware('can:role:view');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('setting.role.create');
    Route::get('/roles/show/{uuid}', [RoleController::class, 'show'])->name('setting.role.show');
    Route::get('/select', [RoleController::class, 'select'])->name('setting.role.select');
    Route::get('/roles/edit/{uuid}', [RoleController::class, 'edit'])->name('setting.role.edit');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('setting.role.store');
    Route::get('/roles/data', [RoleController::class, 'data'])->name('setting.role.data');
    Route::put('/roles/update/{uuid}', [RoleController::class, 'update'])->name('setting.role.update');
    Route::delete('/roles/delete/{uuid}', [RoleController::class, 'destroy'])->name('setting.role.destroy');
});