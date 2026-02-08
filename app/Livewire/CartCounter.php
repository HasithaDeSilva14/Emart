<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartCounter extends Component
{
    public $count = 0;

    protected $listeners = ['cart-updated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (!Auth::check()) {
            $this->count = 0;
            return;
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        
        if ($cart) {
            $this->count = $cart->items()->sum('quantity');
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
