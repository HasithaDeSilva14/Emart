<div class="container" style="padding: 2rem 1.5rem;">
    <h1 style="margin-bottom: 2rem;">My Wishlist</h1>

    @if(session()->has('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlistItems->count() > 0)
        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            @foreach($wishlistItems as $item)
                <div class="product-card">
                    <img src="{{ $item->product->image_path ?? '/images/placeholder-product.png' }}" 
                         alt="{{ $item->product->name }}" 
                         class="product-image">
                    <div class="product-body">
                        <h3 class="product-title">{{ $item->product->name }}</h3>
                        <div class="product-price">{{ format_currency($item->product->price) }}</div>
                        
                        <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                            <button wire:click="addToCart({{ $item->product_id }})" 
                                    class="btn btn-primary" 
                                    style="flex: 1;">
                                Add to Cart
                            </button>
                            <button wire:click="removeFromWishlist({{ $item->product_id }})" 
                                    class="btn btn-ghost" 
                                    title="Remove from wishlist">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card text-center" style="padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">❤️</div>
            <h3 style="margin-bottom: 1rem;">Your wishlist is empty</h3>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">
                Start adding products you love to your wishlist!
            </p>
            <a href="{{ url('/products') }}" class="btn btn-primary">Browse Products</a>
        </div>
    @endif
</div>
