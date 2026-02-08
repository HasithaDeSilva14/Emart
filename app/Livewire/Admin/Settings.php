<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Settings extends Component
{
    public $site_name = 'E-Mart';
    public $site_email = 'admin@emart.com';
    public $currency = 'LKR';
    public $tax_rate = 10;
    public $shipping_fee = 10;

    public function mount()
    {
        // Load settings from config or database
        $this->site_name = config('app.name', 'E-Mart');
    }

    public function save()
    {
        // Save settings logic here
        session()->flash('success', 'Settings saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings')->layout('layouts.admin');
    }
}
