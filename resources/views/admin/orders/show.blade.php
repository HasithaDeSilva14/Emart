<x-admin-layout>
    <div class="container" style="padding: 2rem 1.5rem;">
        <!-- Header -->
        <div class="flex justify-between items-center mb-xl">
            <div class="flex items-center gap-md">
                <a href="{{ route('admin.orders') }}" class="btn btn-outline btn-sm">
                    ← Back to Orders
                </a>
                <h1 style="margin: 0;">Order #{{ $order->id }}</h1>
                <span class="badge {{ $order->status === 'pending' ? 'badge-warning' : ($order->status === 'processing' ? 'badge-info' : (in_array($order->status, ['shipped', 'delivered']) ? 'badge-success' : 'badge-danger')) }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="text-secondary">
                Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}
            </div>
        </div>

        <div class="grid grid-cols-3 gap-lg">
            <!-- Main Content: Items -->
            <div class="col-span-2">
                <div class="card mb-lg">
                    <h3 class="card-header">Order Items</h3>
                    <div class="table-responsive">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                                    <th class="p-sm">Product</th>
                                    <th class="p-sm text-right">Price</th>
                                    <th class="p-sm text-center">Qty</th>
                                    <th class="p-sm text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td class="p-sm">
                                            <div class="flex items-center gap-md">
                                                @if($item->product && $item->product->image_path)
                                                    <img src="{{ asset($item->product->image_path) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         style="width: 48px; height: 48px; object-fit: cover; border-radius: var(--radius-sm);">
                                                @else
                                                    <div style="width: 48px; height: 48px; background: var(--background-secondary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">
                                                        <span style="font-size: 1.5rem;">📦</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-bold">{{ $item->product->name ?? 'Deleted Product' }}</div>
                                                    <small class="text-secondary">SKU: {{ $item->product->id ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-sm text-right">{{ format_currency($item->price) }}</td>
                                        <td class="p-sm text-center">{{ $item->quantity }}</td>
                                        <td class="p-sm text-right">{{ format_currency($item->price * $item->quantity) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="p-md text-right font-bold">Total Amount:</td>
                                    <td class="p-md text-right font-bold text-xl text-primary">
                                        {{ format_currency($order->total_amount) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Customer & Info -->
            <div>
                <!-- Customer Details -->
                <div class="card mb-md">
                    <h3 class="card-header">Customer Details</h3>
                    <div class="p-md">
                        <div class="flex items-center gap-md mb-md">
                            <div style="width: 40px; height: 40px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ substr($order->user->name ?? 'G', 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold">{{ $order->user->name ?? 'Guest User' }}</div>
                                <div class="text-secondary text-sm">{{ $order->user->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="text-sm">
                            <div class="mb-sm">
                                <strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="card mb-md">
                    <h3 class="card-header">Shipping Information</h3>
                    <div class="p-md">
                        <div class="text-secondary">
                            {{ $order->shipping_address }}
                        </div>
                        @if($order->tracking_number)
                            <div class="mt-md p-sm bg-background-secondary rounded">
                                <strong>Tracking #:</strong> 
                                <span class="font-mono">{{ $order->tracking_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="card">
                    <h3 class="card-header">Payment Status</h3>
                    <div class="p-md">
                        <div class="flex justify-between mb-sm">
                            <span>Method:</span>
                            <span class="font-bold capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Status:</span>
                            <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
