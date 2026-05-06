<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC ROUTES (No login required)
// ==========================================

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/explore', function () {
    $categories = \App\Models\Category::all();
    $products = \App\Models\Product::with('category')
        ->where('status', '!=', 'expired')
        ->latest()
        ->take(12)
        ->get();

    return view('explore', compact('categories', 'products'));
})->name('explore')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/cart', [CartController::class, 'index'])->name('cart');

    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/increase', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/select-address', [CartController::class, 'selectAddress'])->name('cart.selectAddress');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'process'])->name('checkout.process');

    Route::resource('products', ProductController::class);

    // 5. Product Details (If you want to hide add-to-cart behind login)
    // Route::get('/product/{id}', [...]);
    Route::resource('addresses', AddressController::class);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/reviews/create/{product_id}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/product/{product_id}', [ReviewController::class, 'show'])->name('reviews.show');

    Route::get('/my-transactions', [OrderController::class, 'index'])->name('my-transactions');
});

// Breeze Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';