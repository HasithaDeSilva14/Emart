<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;

class Payments extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function render()
    {
        $payments = Order::query()
            ->whereIn('payment_method', ['card', 'stripe'])
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('sandbox_transaction_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('payment_status', $this->status);
            })
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.payments', [
            'payments' => $payments,
        ])->layout('layouts.admin');
    }
}
