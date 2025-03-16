<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SendEmailController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/private-files/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path("app/private/{$folder}/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => mime_content_type($path),
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
    ]);
});

Route::get('/public-files/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path("app/public/{$folder}/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => mime_content_type($path),
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
    ]);
});


Route::get('/user_access', function () {
    return Session::get('user_access');
})->name('user_access');

Route::get('/send-email', [SendEmailController::class, 'sendEmail'])->name('send-email');
