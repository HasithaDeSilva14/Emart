<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

/**
 * UserController
 * 
 * Handles user-specific order views
 */
class UserController extends Controller
{
    /**
     * Display list of orders for the authenticated user
     */
    public function orders()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    /**
     * Display individual order details for the authenticated user
     */
    public function orderShow($id)
    {
        $order = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('orders.show', compact('order'));
    }

    /**
     * Add product to cart (form submission)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cart = \App\Models\Cart::firstOrCreate(['user_id' => auth()->id()]);

        $cartItem = \App\Models\CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock_quantity < $newQuantity) {
                return back()->with('error', 'Insufficient stock for requested quantity.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            \App\Models\CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Store product review
     */
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $exists = \App\Models\Review::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
}
