<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\OrderStatusHistory;

// Diagnostic routes for order status testing
Route::get('/debug-order-status', function () {
    return view('debug-order-status');
});

Route::post('/api/test-order-status', function () {
    try {
        $order = Order::first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'No orders found']);
        }
        
        $oldStatus = $order->status;
        $order->status = 'shipped';
        $saved = $order->save();
        
        $order->refresh();
        
        return response()->json([
            'success' => $saved,
            'old_status' => $oldStatus,
            'new_status' => $order->status,
            'persisted' => $order->status === 'shipped',
            'message' => $saved ? 'Status updated successfully' : 'Failed to save'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});

Route::get('/api/orders-status', function () {
    $orders = Order::select('id', 'status', 'updated_at')
        ->orderBy('id')
        ->limit(10)
        ->get();
    
    return response()->json(['orders' => $orders]);
});

Route::post('/api/update-order-status/{orderId}', function ($orderId) {
    try {
        $order = Order::findOrFail($orderId);
        $oldStatus = $order->status;
        $newStatus = request()->input('status');
        
        $order->status = $newStatus;
        $saved = $order->save();
        
        if ($saved) {
            OrderStatusHistory::create([
                'order_id' => $orderId,
                'status' => $newStatus,
                'notes' => 'Updated via diagnostic tool',
                'created_by' => auth()->id() ?? 1,
            ]);
        }
        
        $order->refresh();
        
        return response()->json([
            'success' => $saved,
            'order_id' => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $order->status,
            'persisted' => $order->status === $newStatus,
            'message' => $saved ? "Status updated from {$oldStatus} to {$newStatus}" : 'Failed to save'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});
