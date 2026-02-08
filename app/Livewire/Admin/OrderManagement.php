<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 15;

    protected $queryString = ['search', 'statusFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updateStatus($orderId, $status)
    {
        \Illuminate\Support\Facades\Log::info("Attempting to update Order #{$orderId} to status: {$status}");

        try {
            // Use direct update to ensure DB persistence and bypass potential model quirks
            $updated = Order::where('id', $orderId)->update(['status' => $status]);
            
            if ($updated === 0) {
                \Illuminate\Support\Facades\Log::warning("Order #{$orderId} update affected 0 rows.");
                // Check if it already has that status
                $current = Order::find($orderId);
                if ($current && $current->status === $status) {
                     // It's technically a success if it's already that value
                } else {
                     session()->flash('error', 'Failed to update order status (database returned 0)');
                     return;
                }
            } else {
                 \Illuminate\Support\Facades\Log::info("Order #{$orderId} successfully updated to {$status}");
            }

            $order = Order::find($orderId);

            // Record status history
            OrderStatusHistory::create([
                'order_id' => $orderId,
                'status' => $status,
                'notes' => null,
                'created_by' => auth()->id(),
            ]);
            
            // Update timestamps based on status
            if ($status === 'shipped' && !$order->shipped_at) {
                $order->update(['shipped_at' => now()]);
            } elseif ($status === 'delivered' && !$order->delivered_at) {
                $order->update(['delivered_at' => now()]);
            }
            
            $this->dispatch('statusUpdated');
            session()->flash('success', "Order #{$orderId} status updated to {$status}");
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Order update error: " . $e->getMessage());
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateTracking($orderId, $trackingNumber)
    {
        $order = Order::find($orderId);
        
        if ($order) {
            $order->update(['tracking_number' => $trackingNumber]);
            
            // Record in history
            OrderStatusHistory::create([
                'order_id' => $orderId,
                'status' => $order->status,
                'notes' => 'Tracking number added: ' . $trackingNumber,
                'created_by' => auth()->id(),
            ]);
            
            session()->flash('success', 'Tracking number updated!');
        }
    }

    public function render()
    {
        $query = Order::with('user');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.order-management', [
            'orders' => $orders,
        ])->layout('layouts.admin', ['title' => 'Manage Orders - Admin']);
    }
}
