<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartIndex extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        if (!Auth::check()) {
            $this->cartItems = [];
            $this->calculateTotals();
            return;
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        
        if ($cart) {
            $this->cartItems = $cart->items()
                ->with('product')
                ->get()
                ->toArray();
        } else {
            $this->cartItems = [];
        }

        $this->calculateTotals();
    }

    public function updateQuantity($itemId, $quantity)
    {
        if ($quantity < 1) {
            return;
        }

        $cartItem = CartItem::find($itemId);
        
        if ($cartItem && $cartItem->cart->user_id === Auth::id()) {
            $cartItem->update(['quantity' => $quantity]);
            $this->loadCart();
            $this->dispatch('cart-updated');
            session()->flash('success', 'Quantity updated');
        }
    }

    public function removeItem($itemId)
    {
        $cartItem = CartItem::find($itemId);
        
        if ($cartItem && $cartItem->cart->user_id === Auth::id()) {
            $cartItem->delete();
            $this->loadCart();
            $this->dispatch('cart-updated');
            session()->flash('success', 'Item removed from cart');
        }
    }

    public function clearCart()
    {
        if (!Auth::check()) {
            return;
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        
        if ($cart) {
            $cart->items()->delete();
            $this->loadCart();
            $this->dispatch('cart-updated');
            session()->flash('success', 'Cart cleared');
        }
    }

    private function calculateTotals()
    {
        $this->subtotal = collect($this->cartItems)->sum(function ($item) {
            return $item['product']['price'] * $item['quantity'];
        });

        $this->tax = $this->subtotal * 0.1;
        $this->total = $this->subtotal + $this->tax;
    }

    public function render()
    {
        return view('livewire.cart.cart-index')->layout('layouts.app', ['title' => 'Shopping Cart - E-Mart']);
    }
}
