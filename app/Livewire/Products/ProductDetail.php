<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends Component
{
    public $product;
    public $quantity = 1;
    public $rating = 5;
    public $comment = '';

    protected $rules = [
        'quantity' => 'required|integer|min:1',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:10|max:1000',
    ];

    public function mount($productId)
    {
        $this->product = Product::with(['category', 'reviews.user'])
            ->findOrFail($productId);
            
        if (!$this->product->is_active) {
            abort(404);
        }
    }

    public function addToCart()
    {
        $this->validate(['quantity' => 'required|integer|min:1|max:' . $this->product->stock_quantity]);

        if (!Auth::check()) {
            session()->flash('error', 'Please login to add items to cart');
            return redirect('/login');
        }

        if ($this->product->stock_quantity < $this->quantity) {
            session()->flash('error', 'Not enough stock available');
            return;
        }

        // Get or create cart
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Check if item already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $this->quantity;
            if ($newQuantity > $this->product->stock_quantity) {
                session()->flash('error', 'Cannot add more than available stock');
                return;
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
            ]);
        }

        $this->dispatch('cart-updated');
        session()->flash('success', 'Product added to cart!');
        $this->quantity = 1;
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to submit a review');
            return redirect('/login');
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        session()->flash('success', 'Review submitted successfully!');
        $this->rating = 5;
        $this->comment = '';
        
        // Reload product to get updated reviews
        $this->product->load('reviews.user');
    }

    public function render()
    {
        $relatedProducts = Product::where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->active()
            ->limit(4)
            ->get();

        return view('livewire.products.product-detail', [
            'relatedProducts' => $relatedProducts,
        ])->layout('layouts.app', ['title' => $this->product->name . ' - E-Mart']);
    }
}
