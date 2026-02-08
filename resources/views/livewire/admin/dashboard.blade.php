<div>
    <div class="container" style="padding: 2rem 1.5rem;">
        <h1 class="mb-xl">Admin Dashboard</h1>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-4 gap-md mb-xl">
            <div class="card text-center">
                <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary);">{{ $totalProducts }}</div>
                <p class="text-secondary">Total Products</p>
            </div>
            
            <div class="card text-center">
                <div style="font-size: 2.5rem; font-weight: 700; color: var(--secondary);">{{ $totalOrders }}</div>
                <p class="text-secondary">Total Orders</p>
            </div>
            
            <div class="card text-center">
                <div style="font-size: 2.5rem; font-weight: 700; color: var(--success);">{{ format_currency($totalRevenue) }}</div>
                <p class="text-secondary">Total Revenue</p>
            </div>
            
            <div class="card text-center">
                <div style="font-size: 2.5rem; font-weight: 700; color: var(--warning);">{{ $pendingOrders }}</div>
                <p class="text-secondary">Pending Orders</p>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="mb-xl">
            <h3 class="mb-md">Quick Actions</h3>
            <div class="flex gap-md">
                <a href="/admin/products/create" class="btn btn-primary">➕ Add Product</a>
                <a href="/admin/categories" class="btn btn-outline">📁 Manage Categories</a>
                <a href="/admin/orders" class="btn btn-outline">📦 View Orders</a>
            </div>
        </div>
        
        <!-- Low Stock Alerts -->
        @if($lowStockProducts->count() > 0)
            <div class="mb-xl">
                <h3 class="mb-md">⚠️ Low Stock Alerts</h3>
                <div class="card">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                                <th class="p-sm">Product</th>
                                <th class="p-sm">Category</th>
                                <th class="p-sm">Current Stock</th>
                                <th class="p-sm">Threshold</th>
                                <th class="p-sm">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td class="p-sm">{{ $product->name }}</td>
                                    <td class="p-sm">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="p-sm">
                                        <span class="badge badge-warning">{{ $product->stock_quantity }}</span>
                                    </td>
                                    <td class="p-sm">{{ $product->low_stock_threshold }}</td>
                                    <td class="p-sm">
                                        <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-primary">Restock</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
        <!-- Recent Orders -->
        <div>
            <h3 class="mb-md">Recent Orders</h3>
            <div class="card">
                @if($recentOrders->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                                <th class="p-sm">Order ID</th>
                                <th class="p-sm">Customer</th>
                                <th class="p-sm">Total</th>
                                <th class="p-sm">Status</th>
                                <th class="p-sm">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td class="p-sm">#{{ $order->id }}</td>
                                    <td class="p-sm">{{ $order->user->name }}</td>
                                    <td class="p-sm">{{ format_currency($order->total_amount) }}</td>
                                    <td class="p-sm">
                                        @if($order->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge badge-info">Processing</span>
                                        @elseif($order->status === 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="p-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-secondary">No orders yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
