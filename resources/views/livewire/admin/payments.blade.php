<div>
    <div class="page-header">
        <h1>Payments</h1>
        <p class="text-secondary">View all payment transactions</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="grid grid-cols-2 gap-md">
                <input type="text" wire:model.live="search" class="form-input" placeholder="Search by order ID or transaction ID...">
                <select wire:model.live="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>#{{ $payment->id }}</td>
                            <td>{{ $payment->user->name }}</td>
                            <td>{{ format_currency($payment->total_amount) }}</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td>{{ $payment->sandbox_transaction_id ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ $payment->payment_status === 'paid' ? 'success' : ($payment->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No payments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $payments->links() }}
        </div>
    </div>
</div>
