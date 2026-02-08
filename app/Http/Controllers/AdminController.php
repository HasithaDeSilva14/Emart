<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

/**
 * AdminController - DEPRECATED
 * 
 * Most methods in this controller have been replaced by Livewire components.
 * This controller is kept only for the orderShow method which displays individual order details.
 * 
 * Deprecated Methods (now handled by Livewire):
 * - dashboard() → App\Livewire\Admin\Dashboard
 * - products() → App\Livewire\Admin\ProductTable
 * - productCreate() → App\Livewire\Admin\ProductForm
 * - productEdit() → App\Livewire\Admin\ProductForm
 * - categories() → App\Livewire\Admin\CategoryManagement
 * - orders() → App\Livewire\Admin\OrderManagement
 */
class AdminController extends Controller
{
    /**
     * Display individual order details
     * This is the only active method in this controller
     */
    public function orderShow($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
