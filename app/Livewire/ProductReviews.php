<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductReviews extends Component
{
    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        // we use with('reviews.user') and refresh the product model
        // to ensure we get the latest reviews for the poll
        $this->product->refresh();
        $this->product->load(['reviews.user']);
        
        return view('livewire.product-reviews');
    }
}
