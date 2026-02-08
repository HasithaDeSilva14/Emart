@extends('layouts.app')

@section('title', 'Home - E-Mart')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content container">
        <h1 class="fade-in-up">Welcome to E-Mart</h1>
        <p class="fade-in-up">Discover amazing products at unbeatable prices</p>
        <a href="{{ url('/products') }}" class="btn btn-primary btn-lg fade-in-up">Shop Now</a>
    </div>
</section>

<!-- Featured Categories -->
<section class="container" style="padding: 4rem 1.5rem;">
    <h2 class="text-center mb-xl">Shop by Category</h2>
    <div class="grid grid-cols-4">
        @forelse($categories->take(4) as $category)
            <a href="{{ url('/products?category=' . $category->id) }}" class="card text-center" style="text-decoration: none;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                <h4>{{ $category->name }}</h4>
                <p class="text-secondary">{{ $category->products_count }} products</p>
            </a>
        @empty
            <p class="text-center text-secondary">No categories available</p>
        @endforelse
    </div>
</section>

<!-- Featured Products -->
<section class="container" style="padding: 2rem 1.5rem 4rem;">
    <div class="flex items-center justify-between mb-xl">
        <h2>Featured Products</h2>
        <a href="{{ url('/products') }}" class="btn btn-outline">View All</a>
    </div>
    <div class="grid grid-cols-4">
        @forelse($featuredProducts as $product)
            <div class="product-card">
                <div style="position: relative;">
                    <img src="{{ $product->image_path ?? '/images/placeholder-product.png' }}" 
                         alt="{{ $product->name }}" 
                         class="product-image">
                    @auth
                        <button class="wishlist-btn" 
                                data-product-id="{{ $product->id }}"
                                onclick="toggleWishlist({{ $product->id }}, this)"
                                style="position: absolute; top: 0.75rem; right: 0.75rem; background: white; border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    @endauth
                </div>
                <div class="product-body">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <div class="product-rating">
                        @php
                            $rating = $product->average_rating ?? 0;
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                        @endphp
                        @for($i = 0; $i < 5; $i++)
                            @if($i < $fullStars)
                                <span class="star">★</span>
                            @elseif($i == $fullStars && $hasHalfStar)
                                <span class="star">★</span>
                            @else
                                <span class="star empty">★</span>
                            @endif
                        @endfor
                        <span class="text-secondary">({{ $product->reviews_count ?? 0 }})</span>
                    </div>
                    <div class="product-price">{{ format_currency($product->price) }}</div>
                    @if($product->total_ordered > 0)
                        <div class="badge badge-success" style="margin-bottom: 0.5rem;">
                            🔥 {{ $product->total_ordered }} sold
                        </div>
                    @endif
                    <a href="{{ url('/products/' . $product->id) }}" class="btn btn-primary w-full">View Details</a>
                </div>
            </div>
        @empty
            <p class="text-center text-secondary">No products available</p>
        @endforelse
    </div>
</section>

<!-- Newsletter Section -->
<section style="background: linear-gradient(135deg, var(--primary), var(--accent)); padding: 4rem 0; margin-top: 3rem;">
    <div class="container text-center" style="color: white;">
        <h2 style="color: white;">Stay Updated</h2>
        <p style="opacity: 0.9; margin-bottom: 2rem;">Subscribe to our newsletter for exclusive deals and updates</p>
        <form class="flex gap-md justify-center" style="max-width: 500px; margin: 0 auto;">
            <input type="email" placeholder="Enter your email" class="form-input" style="flex: 1;">
            <button type="submit" class="btn btn-secondary">Subscribe</button>
        </form>
    </div>
</section>
@endsection
