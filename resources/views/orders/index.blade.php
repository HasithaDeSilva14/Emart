@extends('layouts.app')

@section('title', 'My Orders - E-Mart')

@section('content')
<div class="container" style="padding: 2rem 1.5rem;">
    <h1 class="mb-xl">My Orders</h1>
    
    @if($orders->count() > 0)
        <div class="grid gap-md">
            @foreach($orders as $order)
                <div class="card">
                    <div class="flex justify-between items-start mb-md">
                        <div>
                            <h3>Order #{{ $order->id }}</h3>
                            <p class="text-secondary">{{ $order->created_at->format('F j, Y') }}</p>
                        </div>
                        <div class="flex gap-sm items-center">
                            <span class="badge 
                                @if($order->status === 'pending') badge-warning
                                @elseif($order->status === 'processing') badge-info
                                @elseif($order->status === 'completed') badge-success
                                @else badge-danger
                                @endif">
                                {{ strtoupper($order->status) }}
                            </span>
                            
                            @if($order->payment_status)
                            <span class="badge 
                                @if($order->payment_status === 'paid') badge-success
                                @elseif($order->payment_status === 'failed') badge-danger
                                @else badge-warning
                                @endif">
                                {{ strtoupper($order->payment_status) }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-md">
                        <p class="text-secondary mb-sm">{{ $order->items->count() }} item(s)</p>
                        
                        <!-- Show first 3 items -->
                        <div class="flex gap-sm mb-sm">
                            @foreach($order->items->take(3) as $item)
                                <img src="{{ $item->product->image_path ?? '/images/placeholder-product.png' }}" 
                                     alt="{{ $item->product->name }}" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: var(--radius-sm);"
                                     onerror="this.src='/images/placeholder-product.png'">
                            @endforeach
                            
                            @if($order->items->count() > 3)
                                <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: var(--bg-secondary); border-radius: var(--radius-sm); font-weight: 600;">
                                    +{{ $order->items->count() - 3 }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div>
                            <p style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                                {{ format_currency($order->total_amount) }}
                            </p>
                            @if($order->payment_method)
                                <p class="text-secondary" style="font-size: 0.875rem;">
                                    @if($order->payment_method === 'stripe')
                                        💳 Card Payment
                                    @else
                                        💵 Cash on Delivery
                                    @endif
                                </p>
                            @endif
                        </div>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-lg">
            {{ $orders->links() }}
        </div>
    @else
        <div class="card text-center" style="padding: 3rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
            <h3 class="mb-md">No Orders Yet</h3>
            <p class="text-secondary mb-lg">You haven't placed any orders yet.</p>
            <a href="/products" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection
