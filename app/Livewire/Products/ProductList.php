<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'name';
    public $minPrice = '';
    public $maxPrice = '';
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to add items to cart');
            return redirect('/login');
        }

        $product = Product::find($productId);

        if (!$product || !$product->is_active) {
            session()->flash('error', 'Product not available');
            return;
        }

        if ($product->stock_quantity < 1) {
            session()->flash('error', 'Product out of stock');
            return;
        }

        // Get or create cart
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Check if item already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $this->dispatch('cart-updated');
        session()->flash('success', 'Product added to cart!');
    }

    public function render()
    {
        $query = Product::with('category')->active();

        // Search
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Category filter
        if ($this->category) {
            $query->whereHas('category', function ($q) {
                $q->where('name', $this->category);
            });
        }

        // Price filter
        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->paginate($this->perPage);
        $categories = \App\Models\Category::withCount('products')->get();

        return view('livewire.products.product-list', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.app', ['title' => 'Products - E-Mart']);
    }
}
