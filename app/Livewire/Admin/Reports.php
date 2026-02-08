<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Reports extends Component
{
    public $dateRange = '30'; // days

    public function render()
    {
        $startDate = now()->subDays($this->dateRange);

        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')
                ->where('created_at', '>=', $startDate)
                ->sum('total_amount'),
            'total_orders' => Order::where('created_at', '>=', $startDate)->count(),
            'new_users' => User::where('created_at', '>=', $startDate)->count(),
            'products_sold' => DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.created_at', '>=', $startDate)
                ->sum('order_items.quantity'),
        ];

        return view('livewire.admin.reports', [
            'stats' => $stats,
        ])->layout('layouts.admin');
    }
}
