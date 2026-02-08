<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $lowStockProducts = Product::lowStock()->with('category')->get();
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $pendingOrders = Order::where('status', 'pending')->count();

        return view('livewire.admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'lowStockProducts' => $lowStockProducts,
            'recentOrders' => $recentOrders,
            'pendingOrders' => $pendingOrders,
        ])->layout('layouts.admin', ['title' => 'Admin Dashboard - E-Mart']);
    }
}
