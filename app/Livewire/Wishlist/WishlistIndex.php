<?php

namespace App\Livewire\Wishlist;

use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;

class WishlistIndex extends Component
{
    public function removeFromWishlist($productId)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();

        $this->dispatch('wishlist-updated');
        session()->flash('success', 'Product removed from wishlist');
    }

    public function addToCart($productId)
    {
        // Get or create cart for the user
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Check if product already in cart
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        session()->flash('success', 'Product added to cart');
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.wishlist.wishlist-index', [
            'wishlistItems' => $wishlistItems,
        ])->layout('layouts.app', ['title' => 'My Wishlist - E-Mart']);
    }
}
