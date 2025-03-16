<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('can:user:view');
    Route::get('/data', [UserController::class, 'data'])->name('user.data');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/show/{uuid}', [UserController::class, 'show'])->name('user.show');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/edit/{uuid}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update/{uuid}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/delete/{uuid}', [UserController::class, 'destroy'])->name('user.delete');
});

Route::prefix('user_roles')->group(function () {
    Route::get('/data', [UserRoleController::class, 'data'])->name('user_role.data');
    Route::post('/store', [UserRoleController::class, 'store'])->name('user_role.store');
    Route::delete('/delete/{uuid}', [UserRoleController::class, 'destroy'])->name('user_role.delete');
});