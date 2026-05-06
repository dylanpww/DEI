<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menampilkan form untuk membuat review (Biasanya jarang dipakai jika form ada di halaman produk)
     */
    public function create($product_id)
{
    $product = \App\Models\Product::findOrFail($product_id);
    return view('addReview', compact('product'));
}

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'product_ID' => 'required|exists:products,product_ID',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500',
    ]);

    // Simpan review ke database
    \App\Models\Review::create([
        'user_ID'    => Auth::user()->user_ID,
        'product_ID' => $request->product_ID,
        'rating'     => $request->rating,
        'comment'    => $request->comment,
    ]);

    // REDIRECT: Kembali ke halaman My Transactions
    return redirect()->route('my-transactions')->with('success', 'Review submitted! Thank you for sharing your experience.');
}

    /**
     * Menampilkan semua review (Misal untuk dashboard admin)
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->where('user_ID', Auth::id())
            ->latest()
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    public function show($product_id)
{
    $review = Review::with('product')
        ->where('user_ID', Auth::user()->user_ID)
        ->where('product_ID', $product_id)
        ->firstOrFail();

    return view('showReview', compact('review'));
}
}