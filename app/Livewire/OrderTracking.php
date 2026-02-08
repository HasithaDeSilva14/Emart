<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderTracking extends Component
{
    public $orderId;
    public $order;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->loadOrder();
    }

    public function loadOrder()
    {
        $this->order = Order::with(['statusHistory.createdBy', 'items.product'])
            ->where('id', $this->orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    }

    public function getStatusSteps()
    {
        $allStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        $currentIndex = array_search($this->order->status, $allStatuses);
        
        return collect($allStatuses)->map(function($status, $index) use ($currentIndex) {
            return [
                'status' => $status,
                'label' => ucfirst($status),
                'completed' => $index <= $currentIndex,
                'active' => $index == $currentIndex,
            ];
        });
    }

    public function render()
    {
        return view('livewire.order-tracking', [
            'statusSteps' => $this->getStatusSteps(),
        ])->layout('layouts.app', ['title' => 'Track Order #' . $this->orderId]);
    }
}
