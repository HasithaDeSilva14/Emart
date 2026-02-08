<div>
    <div class="container" style="padding: 2rem 1.5rem;">
        <h1 class="mb-xl">Products</h1>
        
        @if (session()->has('success'))
            <div class="alert alert-success mb-lg" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: var(--radius-md);">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="alert alert-error mb-lg" style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: var(--radius-md);">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Filters -->
        <div class="card mb-lg">
            <div class="grid grid-cols-4 gap-md">
                <div class="form-group">
                    <label class="form-label">Search</label>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-input" placeholder="Search products...">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select wire:model.live="category" class="form-input">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }} ({{ $cat->products_count }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Sort By</label>
                    <select wire:model.live="sortBy" class="form-input">
                        <option value="name">Name (A-Z)</option>
                        <option value="price_low">Price (Low to High)</option>
                        <option value="price_high">Price (High to Low)</option>
                        <option value="newest">Newest First</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Price Range</label>
                    <div class="flex gap-sm">
                        <input type="number" wire:model.live.debounce.500ms="minPrice" class="form-input" placeholder="Min" min="0" step="0.01">
                        <input type="number" wire:model.live.debounce.500ms="maxPrice" class="form-input" placeholder="Max" min="0" step="0.01">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Debug Info -->
        <div class="card mb-md" style="background: #fff3cd; border: 1px solid #ffc107; padding: 1rem;">
            <strong>Debug Info:</strong> Found {{ $products->total() }} total products, showing {{ $products->count() }} on this page
        </div>
        
        <!-- Products Grid -->
        <div wire:loading.class="opacity-50">
            @if($products->count() > 0)
                <div class="grid grid-cols-4 gap-lg mb-xl">
                    @foreach($products as $product)
                        <div class="card product-card">
                            <div style="position: relative;">
                                <a href="/products/{{ $product->id }}">
                                    <img src="{{ $product->image_path ?? '/images/placeholder-product.png' }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image">
                                </a>
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
                            
                            <div class="p-md">
                                <a href="/products/{{ $product->id }}" class="product-title">
                                    {{ $product->name }}
                                </a>
                                
                                <p class="text-secondary mb-sm" style="font-size: 0.875rem;">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </p>
                                
                                <div class="flex items-center justify-between mb-md">
                                    <span class="product-price">{{ format_currency($product->price) }}</span>
                                    @if($product->stock_quantity > 0)
                                        <span class="badge" style="background: #d4edda; color: #155724;">In Stock</span>
                                    @else
                                        <span class="badge" style="background: #f8d7da; color: #721c24;">Out of Stock</span>
                                    @endif
                                </div>
                                
                                <button wire:click="addToCart({{ $product->id }})" 
                                        class="btn btn-primary w-full"
                                        {{ $product->stock_quantity < 1 ? 'disabled' : '' }}
                                        wire:loading.attr="disabled"
                                        wire:target="addToCart({{ $product->id }})">
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                        Add to Cart
                                    </span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">
                                        Adding...
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-lg">
                    {{ $products->links() }}
                </div>
            @else
                <div class="card text-center" style="padding: 3rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
                    <h3>No products found</h3>
                    <p class="text-secondary">Try adjusting your filters</p>
                </div>
            @endif
        </div>
    </div>
</div>
