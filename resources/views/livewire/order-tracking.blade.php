<div class="container" style="padding: 2rem 1.5rem;">
    <div class="flex items-center justify-between mb-xl">
        <h1>Track Order #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-ghost">← Back to Orders</a>
    </div>

    <!-- Order Status Timeline -->
    <div class="card mb-xl">
        <div class="card-header">
            <h2>Order Status</h2>
        </div>
        <div class="card-body">
            <!-- Status Progress Bar -->
            <div class="status-timeline">
                @foreach($statusSteps as $step)
                    <div class="status-step {{ $step['completed'] ? 'completed' : '' }} {{ $step['active'] ? 'active' : '' }}">
                        <div class="status-icon">
                            @if($step['completed'])
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                            @else
                                <div class="status-dot"></div>
                            @endif
                        </div>
                        <div class="status-label">{{ $step['label'] }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Current Status Info -->
            <div class="alert alert-info mt-lg">
                <strong>Current Status:</strong> {{ ucfirst($order->status) }}
                @if($order->tracking_number)
                    <br><strong>Tracking Number:</strong> {{ $order->tracking_number }}
                @endif
                @if($order->shipped_at)
                    <br><strong>Shipped:</strong> {{ $order->shipped_at->format('M d, Y h:i A') }}
                @endif
                @if($order->delivered_at)
                    <br><strong>Delivered:</strong> {{ $order->delivered_at->format('M d, Y h:i A') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-xl">
        <div class="card-header">
            <h2>Order Items</h2>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ format_currency($item->price) }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td><strong>{{ format_currency($order->total_amount) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Status History -->
    @if($order->statusHistory->count() > 0)
        <div class="card">
            <div class="card-header">
                <h2>Status History</h2>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($order->statusHistory as $history)
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="badge badge-{{ $history->status === 'delivered' ? 'success' : ($history->status === 'cancelled' ? 'danger' : 'primary') }}">
                                        {{ ucfirst($history->status) }}
                                    </span>
                                    <span class="text-secondary" style="font-size: 0.875rem;">
                                        {{ $history->created_at->format('M d, Y h:i A') }}
                                    </span>
                                </div>
                                @if($history->notes)
                                    <p style="margin-top: 0.5rem; color: var(--text-secondary);">{{ $history->notes }}</p>
                                @endif
                                @if($history->createdBy)
                                    <p style="margin-top: 0.25rem; font-size: 0.875rem; color: var(--text-secondary);">
                                        Updated by: {{ $history->createdBy->name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <style>
    .status-timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin: 2rem 0;
        padding: 0 1rem;
    }

    .status-timeline::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: var(--border-color);
        z-index: 0;
    }

    .status-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .status-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--bg-secondary);
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
    }

    .status-step.completed .status-icon {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .status-step.active .status-icon {
        border-color: var(--primary);
        border-width: 3px;
        animation: pulse 2s infinite;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--text-secondary);
    }

    .status-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .status-step.completed .status-label,
    .status-step.active .status-label {
        color: var(--text-primary);
        font-weight: 600;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: -2rem;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary);
        border: 2px solid var(--bg-primary);
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: calc(-2rem + 5px);
        top: 12px;
        bottom: -2rem;
        width: 2px;
        background: var(--border-color);
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(var(--primary-rgb), 0.7);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(var(--primary-rgb), 0);
        }
    }
    </style>
</div>
