<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    /**
     * Get user's cart.
     */
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cart->load(['items.product.category']);

        return response()->json([
            'cart' => $cart,
            'total_items' => $cart->totalItems(),
            'total_price' => $cart->totalPrice(),
        ]);
    }

    /**
     * Add item to cart.
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available',
                'available_stock' => $product->stock_quantity,
            ], 400);
        }

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

        // Check if item already exists in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($product->stock_quantity < $newQuantity) {
                return response()->json([
                    'message' => 'Insufficient stock available',
                    'available_stock' => $product->stock_quantity,
                    'current_cart_quantity' => $cartItem->quantity,
                ], 400);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        $cart->load(['items.product']);

        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart' => $cart,
            'total_items' => $cart->totalItems(),
            'total_price' => $cart->totalPrice(),
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $itemId)
            ->whereHas('cart', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->firstOrFail();

        // Check stock availability
        if ($cartItem->product->stock_quantity < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available',
                'available_stock' => $cartItem->product->stock_quantity,
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $cart = $cartItem->cart->load(['items.product']);

        return response()->json([
            'message' => 'Cart item updated successfully',
            'cart' => $cart,
            'total_items' => $cart->totalItems(),
            'total_price' => $cart->totalPrice(),
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(Request $request, $itemId)
    {
        $cartItem = CartItem::where('id', $itemId)
            ->whereHas('cart', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->firstOrFail();

        $cartItem->delete();

        $cart = Cart::where('user_id', $request->user()->id)->first();
        $cart->load(['items.product']);

        return response()->json([
            'message' => 'Item removed from cart successfully',
            'cart' => $cart,
            'total_items' => $cart->totalItems(),
            'total_price' => $cart->totalPrice(),
        ]);
    }

    /**
     * Clear cart.
     */
    public function clear(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();
        
        if ($cart) {
            $cart->items()->delete();
        }

        return response()->json([
            'message' => 'Cart cleared successfully',
        ]);
    }
}
