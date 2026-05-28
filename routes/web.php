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
    $products = \App\Models\Product::with(['category', 'images'])
        ->where('status', '!=', 'expired')
        ->latest()
        ->take(12)
        ->get();

    $foodWasteSaved = \App\Models\OrderItem::whereHas('order', function($q) {
        $q->whereIn('status', ['success', 'settlement']);
    })->with('product')->get()->sum(function($item) {
        return $item->qty * ($item->product->weight_in_grams ?? 0);
    });

    // Konversi ke KG jika lebih dari 1000 gram
    if ($foodWasteSaved >= 1000) {
        $foodWasteSaved = number_format($foodWasteSaved / 1000, 1) . ' KG';
    } else {
        $foodWasteSaved = $foodWasteSaved . ' Gram';
    }

    return view('explore', compact('categories', 'products', 'foodWasteSaved'));
})->name('explore');

Route::get('/dashboard', function () {
    $foodWasteSaved = \App\Models\OrderItem::whereHas('order', function($q) {
        $q->whereIn('status', ['success', 'settlement']);
    })->with('product')->get()->sum(function($item) {
        return $item->qty * ($item->product->weight_in_grams ?? 0);
    });

    if ($foodWasteSaved >= 1000) {
        $foodWasteSaved = number_format($foodWasteSaved / 1000, 1) . ' KG';
    } else {
        $foodWasteSaved = $foodWasteSaved . ' Gram';
    }

    return view('dashboard', compact('foodWasteSaved'));
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
        return redirect()->route('explore');
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

    // Chat Routes
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/start/{product_id}', [\App\Http\Controllers\ChatController::class, 'start'])->name('chat.start');
    Route::post('/chat/{id}/message', [\App\Http\Controllers\ChatController::class, 'storeMessage'])->name('chat.storeMessage');
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/users/{id}/warn', [\App\Http\Controllers\AdminController::class, 'warnUser'])->name('users.warn');
    Route::post('/users/{id}/block', [\App\Http\Controllers\AdminController::class, 'blockUser'])->name('users.block');
    Route::post('/users/{id}/ban', [\App\Http\Controllers\AdminController::class, 'banUser'])->name('users.ban');
    Route::post('/users/{id}/unblock', [\App\Http\Controllers\AdminController::class, 'unblockUser'])->name('users.unblock');
    Route::post('/users/{id}/make-seller', [\App\Http\Controllers\AdminController::class, 'makeSeller'])->name('users.makeSeller');
    Route::delete('/users/{id}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    
    Route::put('/reviews/{id}', [\App\Http\Controllers\AdminController::class, 'updateReview'])->name('reviews.update');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\AdminController::class, 'deleteReview'])->name('reviews.delete');
});

// Breeze Auth Routes (Login, Register, etc.)
require __DIR__ . '/auth.php';
