<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '' }}@yield('title', 'Admin Dashboard - E-Mart')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    @stack('styles')
</head>
<body x-data="{ sidebarOpen: false }" class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" :class="{ 'open': sidebarOpen }">
            <!-- Logo -->
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <span class="logo-icon">🛒</span>
                    <span class="logo-text">E-Mart Admin</span>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="sidebar-icon">📊</span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <span class="sidebar-icon">👥</span>
                    <span class="sidebar-text">Users</span>
                </a>
                
                <a href="{{ route('admin.payments') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                    <span class="sidebar-icon">💳</span>
                    <span class="sidebar-text">Payments</span>
                </a>
                
                <a href="{{ route('admin.orders') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <span class="sidebar-icon">📦</span>
                    <span class="sidebar-text">Orders</span>
                </a>
                
                <a href="{{ route('admin.reports') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <span class="sidebar-icon">📈</span>
                    <span class="sidebar-text">Reports</span>
                </a>
                
                <a href="{{ route('admin.products') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.products*') || request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <span class="sidebar-icon">📝</span>
                    <span class="sidebar-text">Content / Listings</span>
                </a>
                
                <a href="{{ route('admin.settings') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <span class="sidebar-icon">⚙️</span>
                    <span class="sidebar-text">Settings</span>
                </a>
                
                <a href="{{ route('admin.audit-logs') }}" 
                   class="sidebar-item {{ request()->routeIs('admin.audit-logs*') ? 'active' : '' }}">
                    <span class="sidebar-icon">📋</span>
                    <span class="sidebar-text">Audit Logs</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <a href="/user/profile" 
                   class="sidebar-item {{ request()->is('user/profile*') ? 'active' : '' }}">
                    <span class="sidebar-icon">👤</span>
                    <span class="sidebar-text">Profile</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-item sidebar-logout">
                        <span class="sidebar-icon">🚪</span>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" 
             x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-cloak></div>
        
        <!-- Main Content -->
        <main class="admin-content">
            <!-- Mobile Header -->
            <div class="admin-mobile-header">
                <button @click="sidebarOpen = !sidebarOpen" class="mobile-menu-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <span class="mobile-title">E-Mart Admin</span>
            </div>
            
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Page Content -->
            {{ $slot }}
        </main>
    </div>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    @stack('scripts')
</body>
</html>
