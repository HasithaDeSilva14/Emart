@extends('layouts.app')

@section('title', 'Payment Successful - E-Mart')

@section('content')
<div class="container" style="padding: 4rem 1.5rem; text-align: center; max-width: 600px; margin: 0 auto;">
    <div class="card">
        <!-- Success Icon -->
        <div style="font-size: 4rem; margin-bottom: 1rem;">✅</div>
        
        <h1 style="color: var(--success); margin-bottom: 1rem;">Payment Successful!</h1>
        
        <p style="font-size: 1.125rem; color: var(--text-secondary); margin-bottom: 2rem;">
            Thank you for your purchase. Your payment has been processed successfully.
        </p>
        
        <!-- Order Details -->
        <div style="background: var(--bg-secondary); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; text-align: left;">
            <h3 style="margin-bottom: 1rem;">Order Details</h3>
            
            <div class="flex justify-between mb-sm">
                <span style="color: var(--text-secondary);">Order ID:</span>
                <span style="font-weight: 600;">#{{ $order->id }}</span>
            </div>
            
            <div class="flex justify-between mb-sm">
                <span style="color: var(--text-secondary);">Total Amount:</span>
                <span style="font-weight: 600; color: var(--success);">{{ format_currency($order->total_amount) }}</span>
            </div>
            
            <div class="flex justify-between mb-sm">
                <span style="color: var(--text-secondary);">Payment Method:</span>
                <span style="font-weight: 600;">Credit/Debit Card</span>
            </div>
            
            <div class="flex justify-between">
                <span style="color: var(--text-secondary);">Payment Status:</span>
                <span style="font-weight: 600; color: var(--success);">Paid</span>
            </div>
        </div>
        
        <!-- What's Next -->
        <div style="background: var(--primary-light); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; text-align: left;">
            <h4 style="margin-bottom: 0.5rem;">What's Next?</h4>
            <ul style="margin: 0; padding-left: 1.5rem; color: var(--text-secondary);">
                <li>You will receive an order confirmation email shortly</li>
                <li>We'll notify you when your order ships</li>
                <li>Track your order status in your account</li>
            </ul>
        </div>
        
        <!-- Actions -->
        <div class="flex gap-md justify-center">
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">
                View Order Details
            </a>
            <a href="/products" class="btn btn-outline">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
