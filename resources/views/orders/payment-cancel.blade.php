@extends('layouts.app')

@section('title', 'Payment Cancelled - E-Mart')

@section('content')
<div class="container" style="padding: 4rem 1.5rem; text-align: center; max-width: 600px; margin: 0 auto;">
    <div class="card">
        <!-- Cancel Icon -->
        <div style="font-size: 4rem; margin-bottom: 1rem;">❌</div>
        
        <h1 style="color: var(--warning); margin-bottom: 1rem;">Payment Cancelled</h1>
        
        <p style="font-size: 1.125rem; color: var(--text-secondary); margin-bottom: 2rem;">
            Your payment was cancelled. No charges have been made to your card.
        </p>
        
        <!-- Information Box -->
        <div style="background: var(--warning-light); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; text-align: left;">
            <h4 style="margin-bottom: 0.5rem;">What happened?</h4>
            <p style="margin: 0; color: var(--text-secondary);">
                You cancelled the payment process or closed the payment window. Your order has been marked as cancelled and no payment was processed.
            </p>
        </div>
        
        <!-- Next Steps -->
        <div style="background: var(--bg-secondary); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; text-align: left;">
            <h4 style="margin-bottom: 0.5rem;">What can you do?</h4>
            <ul style="margin: 0; padding-left: 1.5rem; color: var(--text-secondary);">
                <li>Return to your cart and try again</li>
                <li>Choose a different payment method</li>
                <li>Contact support if you're experiencing issues</li>
            </ul>
        </div>
        
        <!-- Actions -->
        <div class="flex gap-md justify-center">
            <a href="/cart" class="btn btn-primary">
                Return to Cart
            </a>
            <a href="/products" class="btn btn-outline">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
