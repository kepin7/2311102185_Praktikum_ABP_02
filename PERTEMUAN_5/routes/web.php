<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('products.index')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
});

require __DIR__.'/auth.php';