<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '' }}@yield('title', 'E-Mart - Your Premium Online Store')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo - Left Corner -->
            <a href="{{ url('/') }}" class="navbar-brand">
                <span class="logo-icon">🛒</span>
                <span class="logo-text">E-Mart</span>
            </a>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            
            <!-- Main Menu Items -->
            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="{{ url('/') }}" class="navbar-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ url('/products') }}" class="navbar-link {{ request()->is('products*') ? 'active' : '' }}">Products</a></li>
                <li><a href="{{ url('/about') }}" class="navbar-link {{ request()->is('about') ? 'active' : '' }}">About Us</a></li>
            </ul>
            
            <!-- Right Side: Search, Profile, Cart -->
            <div class="navbar-actions">
                <!-- Search Bar -->
                <div class="navbar-search">
                    <form action="{{ url('/products') }}" method="GET" class="search-form">
                        <input type="text" 
                               name="search" 
                               placeholder="Search products..." 
                               class="search-input"
                               value="{{ request('search') }}">
                        <button type="submit" class="search-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                
                @auth
                    <!-- Profile Icon -->
                    <a href="{{ route('profile.show') }}" class="navbar-icon" title="Profile">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </a>
                    
                    <!-- Wishlist Icon with Counter -->
                    <a href="{{ route('wishlist.index') }}" class="navbar-icon cart-icon-wrapper" title="Wishlist">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        <livewire:wishlist-counter />
                    </a>
                    
                    <!-- Cart Icon with Counter -->
                    <a href="{{ url('/cart') }}" class="navbar-icon cart-icon-wrapper" title="Cart">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <livewire:cart-counter />
                    </a>
                    
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm" title="Logout">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.25rem; vertical-align: middle;">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    <!-- Login/Register for guests -->
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                @endauth
                
                <!-- Dark Mode Toggle -->
                <button id="themeToggle" class="navbar-icon" title="Toggle Dark Mode">
                    <span id="themeIcon">🌙</span>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Alert Messages -->
    <div id="alertContainer" class="container" style="margin-top: 1rem;"></div>
    
    <!-- Main Content -->
    <main>
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>About E-Mart</h4>
                    <p style="color: var(--text-secondary);">Sri Lanka's premier online shopping destination for quality electronics at the best prices in LKR.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/products') }}">Products</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/faq') }}">FAQ</a></li>
                        <li><a href="{{ url('/shipping') }}">Shipping Info</a></li>
                        <li><a href="{{ url('/returns') }}">Returns</a></li>
                        <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contact Us</h4>
                    <ul class="footer-links">
                        <li>📧 support@emart.lk</li>
                        <li>📱 +94 11 234 5678</li>
                        <li>📱 +94 77 123 4567</li>
                        <li>📍 No. 123, Galle Road, Colombo 03</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} E-Mart Sri Lanka. All rights reserved. Built with ❤️ using Laravel</p>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Wishlist Toggle Script -->
    <script>
        function toggleWishlist(productId, button) {
            fetch('{{ route("wishlist.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    const svg = button.querySelector('svg');
                    if (data.added) {
                        svg.setAttribute('fill', 'var(--primary)');
                        button.style.background = 'var(--bg-secondary)';
                    } else {
                        svg.setAttribute('fill', 'none');
                        button.style.background = 'white';
                    }
                    
                    // Dispatch event to update counter
                    window.Livewire.dispatch('wishlist-updated');
                    
                    // Show toast message
                    showToast(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to update wishlist', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type}`;
            toast.textContent = message;
            toast.style.cssText = 'position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 250px; animation: slideIn 0.3s ease;';
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    @yield('scripts')
</body>
</html>
