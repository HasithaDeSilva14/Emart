<div>
    <div class="page-header">
        <h1>Reports & Analytics</h1>
        <p class="text-secondary">View business insights and statistics</p>
    </div>

    <div class="grid grid-cols-4 gap-lg" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value">{{ format_currency($stats['total_revenue']) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-label">Total Orders</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">{{ $stats['new_users'] }}</div>
            <div class="stat-label">New Users</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ $stats['products_sold'] }}</div>
            <div class="stat-label">Products Sold</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Date Range</h3>
            <select wire:model.live="dateRange" class="form-select">
                <option value="7">Last 7 Days</option>
                <option value="30">Last 30 Days</option>
                <option value="90">Last 90 Days</option>
                <option value="365">Last Year</option>
            </select>
        </div>

        <div class="card-body">
            <p class="text-secondary">Detailed charts and analytics coming soon...</p>
        </div>
    </div>
</div>
