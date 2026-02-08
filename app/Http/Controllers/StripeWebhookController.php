<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe webhook events
     */
    public function handleWebhook(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            // Verify webhook signature
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $webhookSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe webhook invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe webhook invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe webhook event: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle checkout session completed event
     */
    protected function handleCheckoutSessionCompleted($session)
    {
        $order = Order::where('stripe_checkout_session_id', $session->id)->first();

        if (!$order) {
            Log::error('Order not found for session: ' . $session->id);
            return;
        }

        // Update order if payment is complete
        if ($session->payment_status === 'paid' && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'stripe_payment_intent_id' => $session->payment_intent,
                'paid_at' => now(),
                'status' => 'processing'
            ]);

            Log::info('Order ' . $order->id . ' marked as paid via webhook');
        }
    }

    /**
     * Handle payment intent succeeded event
     */
    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if ($order && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'status' => 'processing'
            ]);

            Log::info('Order ' . $order->id . ' payment confirmed via webhook');
        }
    }

    /**
     * Handle payment intent failed event
     */
    protected function handlePaymentIntentFailed($paymentIntent)
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if ($order && $order->payment_status === 'pending') {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'cancelled'
            ]);

            Log::info('Order ' . $order->id . ' payment failed via webhook');
        }
    }
}
