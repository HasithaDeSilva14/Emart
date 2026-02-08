@extends('layouts.app')

@section('title', 'Order #{{ $order->id }} - E-Mart')

@section('content')
<div class="container" style="padding: 2rem 1.5rem;">
    <div class="flex justify-between items-start mb-xl">
        <div>
            <h1>Order #{{ $order->id }}</h1>
            <p class="text-secondary">Placed on {{ $order->created_at->format('F j, Y') }}</p>
        </div>
        <div class="flex gap-md items-center">
            <a href="{{ route('orders.track', $order->id) }}" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.5rem;">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                Track Order
            </a>
            <span class="badge 
                @if($order->status === 'pending') badge-warning
                @elseif($order->status === 'processing') badge-info
                @elseif($order->status === 'completed') badge-success
                @else badge-danger
                @endif" 
                style="font-size: 1rem; padding: 0.5rem 1rem;">
                {{ strtoupper($order->status) }}
            </span>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-lg">
        <!-- Order Items -->
        <div style="grid-column: span 2;">
            <div class="card">
                <h3 class="mb-lg">Order Items</h3>
                
                @foreach($order->items as $item)
                    <div class="flex gap-md mb-md" style="padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <img src="{{ $item->product->image_path ?? '/images/placeholder-product.png' }}" 
                             alt="{{ $item->product->name }}" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: var(--radius-md);"
                             onerror="this.src='/images/placeholder-product.png'">
                        
                        <div style="flex: 1;">
                            <h4>{{ $item->product->name }}</h4>
                            <p class="text-secondary">Quantity: {{ $item->quantity }}</p>
                            <p class="text-secondary">Price: {{ format_currency($item->price) }}</p>
                        </div>
                        
                        <div class="text-right">
                            <p style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Order Summary -->
        <div>
            <div class="card mb-md">
                <h3 class="mb-md">Order Summary</h3>
                
                @php
                    $subtotal = $order->items->sum(function($item) {
                        return $item->price * $item->quantity;
                    });
                    $shipping = 10.00;
                    $tax = $order->total_amount - $subtotal - $shipping;
                @endphp
                
                <div class="flex justify-between mb-sm">
                    <span>Subtotal:</span>
                    <span>{{ format_currency($subtotal) }}</span>
                </div>
                
                <div class="flex justify-between mb-sm">
                    <span>Tax (10%):</span>
                    <span>{{ format_currency($tax) }}</span>
                </div>
                
                <div class="flex justify-between mb-md">
                    <span>Shipping:</span>
                    <span>{{ format_currency($shipping) }}</span>
                </div>
                
                <div class="flex justify-between" style="padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 1.25rem; font-weight: 700;">
                    <span>Total:</span>
                    <span class="text-primary">{{ format_currency($order->total_amount) }}</span>
                </div>
            </div>
            
            <!-- Payment Information -->
            @if($order->payment_method)
            <div class="card mb-md">
                <h3 class="mb-md">Payment Information</h3>
                
                <div class="flex justify-between mb-sm">
                    <span>Payment Method:</span>
                    <span style="font-weight: 600;">
                        @if($order->payment_method === 'stripe')
                            💳 Credit/Debit Card
                        @else
                            💵 Cash on Delivery
                        @endif
                    </span>
                </div>
                
                <div class="flex justify-between mb-sm">
                    <span>Payment Status:</span>
                    <span class="badge 
                        @if($order->payment_status === 'paid') badge-success
                        @elseif($order->payment_status === 'failed') badge-danger
                        @else badge-warning
                        @endif">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </div>
                
                @if($order->paid_at)
                <div class="flex justify-between">
                    <span>Paid At:</span>
                    <span>{{ $order->paid_at->format('M j, Y H:i') }}</span>
                </div>
                @endif
            </div>
            @endif
            
            <div class="card">
                <h3 class="mb-md">Shipping Address</h3>
                <p class="text-secondary">{{ $order->shipping_address }}</p>
                
                @if($order->phone)
                    <h4 class="mt-lg mb-sm">Phone</h4>
                    <p class="text-secondary">{{ $order->phone }}</p>
                @endif
                
                @if($order->notes)
                    <h4 class="mt-lg mb-sm">Order Notes</h4>
                    <p class="text-secondary">{{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="mt-lg">
        <a href="/orders" class="btn btn-outline">← Back to Orders</a>
    </div>
</div>
@endsection
