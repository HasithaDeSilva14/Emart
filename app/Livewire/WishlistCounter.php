<?php

namespace App\Livewire;

use App\Models\Wishlist;
use Livewire\Component;
use Livewire\Attributes\On;

class WishlistCounter extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('wishlist-updated')]
    public function updateCount()
    {
        $this->count = Wishlist::where('user_id', auth()->id())->count();
    }

    public function render()
    {
        return view('livewire.wishlist-counter');
    }
}
