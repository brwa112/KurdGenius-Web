<?php

use App\Http\Controllers\Pages\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

// Branch-specific routes (e.g., /kurd-genius/news)
Route::middleware('track.visitors')->group(function () {
    Route::get('/safe', [HomeController::class, 'index'])->name('index');
    Route::post('/send-mail', [HomeController::class, 'sendMail'])->name('send.mail');
});
