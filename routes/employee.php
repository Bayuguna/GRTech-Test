<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee.index')->middleware('can:employee:view');
    Route::get('/data', [EmployeeController::class, 'data'])->name('employee.data');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::get('/show/{uuid}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/edit/{uuid}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/update/{uuid}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/delete/{uuid}', [EmployeeController::class, 'destroy'])->name('employee.delete');
});