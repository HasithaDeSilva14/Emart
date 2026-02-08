<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class OrderApiController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Admin can see all orders, customers see only their own
        if ($user->isAdmin()) {
            $orders = Order::with(['user', 'items.product'])->latest()->paginate(20);
        } else {
            $orders = Order::where('user_id', $user->id)
                ->with(['items.product'])
                ->latest()
                ->paginate(20);
        }

        return response()->json($orders);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty',
            ], 400);
        }

        // Check stock availability for all items
        foreach ($cart->items as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                return response()->json([
                    'message' => 'Insufficient stock for product: ' . $item->product->name,
                    'product' => $item->product->name,
                    'available_stock' => $item->product->stock_quantity,
                    'requested_quantity' => $item->quantity,
                ], 400);
            }
        }

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $cart->totalPrice(),
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
            ]);

            // Create order items and update stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Decrease stock quantity
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            // Send email notification (will be caught if mail is not configured)
            try {
                Mail::to($user->email)->send(new OrderPlaced($order));
            } catch (\Exception $e) {
                // Log error but don't fail the order
                \Log::info('Email notification failed: ' . $e->getMessage());
            }

            return response()->json([
                'message' => 'Order placed successfully',
                'order' => $order->load('items.product'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Order creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        
        $query = Order::with(['items.product', 'user']);
        
        // Customers can only see their own orders
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }
        
        $order = $query->findOrFail($id);

        return response()->json($order);
    }

    /**
     * Update order status (admin only).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order->load('items.product'),
        ]);
    }

    /**
     * Get order statistics (admin only).
     */
    public function statistics()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'processing_orders' => Order::processing()->count(),
            'completed_orders' => Order::completed()->count(),
            'total_revenue' => Order::completed()->sum('total_amount'),
            'recent_orders' => Order::with(['user', 'items.product'])->latest()->take(5)->get(),
        ];

        return response()->json($stats);
    }
}
