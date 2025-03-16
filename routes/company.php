<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('companies')->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('company.index')->middleware('can:company:view');
    Route::get('/data', [CompanyController::class, 'data'])->name('company.data');
    Route::get('/select', [CompanyController::class, 'select'])->name('company.select');
    Route::get('/show/{uuid}', [CompanyController::class, 'show'])->name('company.show');
    Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/edit/{uuid}', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/update/{uuid}', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('/delete/{uuid}', [CompanyController::class, 'destroy'])->name('company.delete');
});