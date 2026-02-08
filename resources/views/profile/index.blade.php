@extends('layouts.app')

@section('title', 'My Profile - E-Mart')

@section('content')
<div class="container" style="padding: 2rem 1.5rem; max-width: 1200px;">
    <h1 class="mb-xl">My Profile</h1>

    @if(session('success'))
        <div class="alert alert-success mb-lg" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: var(--radius-md);">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-lg" style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: var(--radius-md);">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-xl">
        <!-- Left Column: Profile Update -->
        <div>
            <div class="card mb-lg">
                <h3 class="mb-lg">Account Information</h3>
                
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-md">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                    </div>
                    
                    <div class="form-group mb-md">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group mb-md">
                        <label class="form-label" for="current_password">Current Password (to change password)</label>
                        <input type="password" id="current_password" name="current_password" class="form-input">
                    </div>

                    <div class="grid grid-cols-2 gap-md">
                        <div class="form-group mb-md">
                            <label class="form-label" for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-input">
                        </div>

                        <div class="form-group mb-md">
                            <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>

            <div class="card" style="border-color: #dc3545;">
                <h3 class="mb-lg text-danger" style="color: #dc3545;">Danger Zone</h3>
                <p class="mb-md text-secondary">Once you delete your account, there is no going back. Please be certain.</p>
                
                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    
                    <div class="form-group mb-md">
                        <label class="form-label" for="password">Confirm Password to Delete</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>

                    <button type="submit" class="btn btn-danger" style="background-color: #dc3545; color: white;">Delete Account</button>
                </form>
            </div>
        </div>

        <!-- Right Column: Stats & Orders -->
        <div>
            <div class="card mb-lg">
                <h3 class="mb-lg">Account Statistics</h3>
                
                <div class="grid grid-cols-2 gap-md">
                    <div class="text-center p-md" style="background: var(--bg-secondary); border-radius: var(--radius-md);">
                        <div style="font-size: 2rem; font-weight: 700; color: var(--primary);">{{ $totalOrders }}</div>
                        <p class="text-secondary">Total Orders</p>
                    </div>
                    
                    <div class="text-center p-md" style="background: var(--bg-secondary); border-radius: var(--radius-md);">
                        <div style="font-size: 2rem; font-weight: 700; color: var(--secondary);">{{ format_currency($totalSpent) }}</div>
                        <p class="text-secondary">Total Spent</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="flex justify-between items-center mb-lg">
                    <h3>Recent Orders</h3>
                    <a href="/orders" class="text-primary" style="text-decoration: none;">View All</a>
                </div>

                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                                    <th class="p-sm">Order ID</th>
                                    <th class="p-sm">Date</th>
                                    <th class="p-sm">Total</th>
                                    <th class="p-sm">Status</th>
                                    <th class="p-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td class="p-sm">#{{ $order->id }}</td>
                                        <td class="p-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="p-sm">{{ format_currency($order->total_amount) }}</td>
                                        <td class="p-sm">
                                            <span style="
                                                padding: 0.25rem 0.5rem; 
                                                border-radius: 999px; 
                                                font-size: 0.85rem;
                                                background: {{ $order->status === 'completed' ? '#d4edda' : ($order->status === 'pending' ? '#fff3cd' : '#e2e3e5') }};
                                                color: {{ $order->status === 'completed' ? '#155724' : ($order->status === 'pending' ? '#856404' : '#383d41') }};
                                            ">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="p-sm">
                                            <a href="/orders/{{ $order->id }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-secondary text-center py-lg">No orders found.</p>
                    <div class="text-center">
                        <a href="/products" class="btn btn-primary">Start Shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
