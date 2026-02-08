<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Handle successful payment callback from Stripe
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        
        if (!$sessionId) {
            return redirect('/cart')->with('error', 'Invalid payment session.');
        }

        // Find order by session ID
        $order = Order::where('stripe_checkout_session_id', $sessionId)->first();

        if (!$order) {
            return redirect('/cart')->with('error', 'Order not found.');
        }

        // Check if already processed
        if ($order->payment_status === 'paid') {
            return view('orders.payment-success', compact('order'));
        }

        // Verify payment with Stripe
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            
            if ($session->payment_status === 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'stripe_payment_intent_id' => $session->payment_intent,
                    'paid_at' => now(),
                    'status' => 'processing'
                ]);

                // Clear cart
                auth()->user()->cart?->items()->delete();
                auth()->user()->cart?->delete();

                return view('orders.payment-success', compact('order'));
            }
        } catch (\Exception $e) {
            \Log::error('Payment verification failed: ' . $e->getMessage());
            return redirect('/cart')->with('error', 'Payment verification failed.');
        }

        return redirect('/cart')->with('error', 'Payment not completed.');
    }

    /**
     * Handle cancelled payment callback from Stripe
     */
    public function cancel(Request $request)
    {
        $sessionId = $request->query('session_id');
        
        if ($sessionId) {
            $order = Order::where('stripe_checkout_session_id', $sessionId)->first();
            
            if ($order && $order->payment_status === 'pending') {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);
            }
        }

        return view('orders.payment-cancel');
    }
}
