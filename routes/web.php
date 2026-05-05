<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// ==========================================
// PUBLIC ROUTES (No login required)
// ==========================================



Route::get('/', function () {
    return view('explore');
})->name('explore');


Route::middleware('auth')->group(function () {
    
    // 3. Shop / Home Screen (Where users buy items)
    Route::get('/home', function () {
        return view('explore'); // Assuming you have the home view created
    })->name('home');

    // 4. Cart Screen
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');

    // 5. Product Details (If you want to hide add-to-cart behind login)
    // Route::get('/product/{id}', [...]);
});

// Breeze Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
