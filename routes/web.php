<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

// ==========================================
// PUBLIC ROUTES (No login required)
// ==========================================

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/explore', function () {
    return view('explore');
})->name('explore');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
    $categories = \App\Models\Category::all();
    return view('explore', compact('categories'));
})->name('explore');

Route::get('/category/{categoryId}', [ProductController::class, 'byCategory'])->name('products.by-category');


Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Shop / Home Screen (Where users buy items)
    Route::get('/home', function () {
        $categories = \App\Models\Category::all();
        return view('explore', compact('categories'));
    })->name('home');

    // 4. Cart Screen
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');

    Route::resource('products', ProductController::class);

    // 5. Product Details (If you want to hide add-to-cart behind login)
    // Route::get('/product/{id}', [...]);
    Route::resource('addresses', AddressController::class);
});

// Breeze Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';

