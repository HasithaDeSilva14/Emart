<div>
    <div class="container" style="padding: 2rem 1.5rem;">
        <h1 class="mb-xl">Manage Orders</h1>
        
        @if (session()->has('success'))
            <div class="alert alert-success mb-lg">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Filters -->
        <div class="card mb-lg">
            <div class="grid grid-cols-2 gap-md">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-input" placeholder="Search by order ID, customer name, or email...">
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <select wire:model.live="statusFilter" class="form-input">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Orders Table -->
        @if($orders->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                                <th class="p-sm">Order ID</th>
                                <th class="p-sm">Customer</th>
                                <th class="p-sm">Total</th>
                                <th class="p-sm">Status</th>
                                <th class="p-sm">Date</th>
                                <th class="p-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr wire:key="order-{{ $order->id }}" style="border-bottom: 1px solid var(--border-color);">
                                    <td class="p-sm">#{{ $order->id }}</td>
                                    <td class="p-sm">
                                        <div>{{ $order->user->name }}</div>
                                        <small class="text-secondary">{{ $order->user->email }}</small>
                                    </td>
                                    <td class="p-sm">{{ format_currency($order->total_amount) }}</td>
                                    <td class="p-sm">
                                        <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                                wire:loading.attr="disabled"
                                                wire:target="updateStatus({{ $order->id }}, $event.target.value)"
                                                class="badge {{ $order->status === 'pending' ? 'badge-warning' : ($order->status === 'processing' ? 'badge-info' : (in_array($order->status, ['shipped', 'delivered']) ? 'badge-success' : 'badge-danger')) }}"
                                                style="cursor: pointer; border: none; padding: 0.25rem 0.5rem; transition: all 0.2s;">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </td>
                                    <td class="p-sm">{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td class="p-sm">
                                        <a href="/admin/orders/{{ $order->id }}" class="btn btn-sm btn-outline">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-lg">
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="card text-center" style="padding: 3rem;">
                <p class="text-secondary">No orders found</p>
            </div>
        @endif
    </div>
</div>
