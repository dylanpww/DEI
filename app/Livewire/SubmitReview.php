<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SubmitReview extends Component
{
    public $showModal = false;
    public $productId;
    public $productName;
    public $rating = 5;
    public $comment = '';

    #[On('open-review-modal')]
    public function openModal($productId)
    {
        $this->productId = $productId;
        $product = Product::find($productId);
        $this->productName = $product ? $product->name : '';
        $this->rating = 5;
        $this->comment = '';
        $this->showModal = true;
    }

    public function saveReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        Review::create([
            'product_ID' => $this->productId,
            'user_ID' => Auth::id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->showModal = false;
        
        session()->flash('success', 'Ulasan berhasil ditambahkan!');
        return redirect()->route('products.show', $this->productId);
    }

    public function render()
    {
        return view('livewire.submit-review');
    }
}
