<div>
    <div class="container" style="padding: 2rem 1.5rem;">
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
        
        <div class="grid grid-cols-2 gap-lg">
            <!-- Product Image -->
            <div>
                <img src="{{ $product->image_path ?? '/images/placeholder-product.png' }}" 
                     alt="{{ $product->name }}" 
                     style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); object-fit: cover;">
            </div>
            
            <!-- Product Info -->
            <div>
                <h1>{{ $product->name }}</h1>
                <div class="product-rating mb-md">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < floor($product->averageRating()))
                            <span class="star">★</span>
                        @else
                            <span class="star empty">★</span>
                        @endif
                    @endfor
                    <span class="text-secondary">({{ $product->reviews->count() }} reviews)</span>
                </div>
                
                <div class="product-price mb-lg" style="font-size: 2.5rem; font-weight: bold; color: var(--primary);">
                    {{ format_currency($product->price) }}
                </div>
                
                <div class="mb-lg">
                    @if($product->stock_quantity > 0)
                        <span class="badge badge-success">In Stock ({{ $product->stock_quantity }} available)</span>
                        @if($product->isLowStock())
                            <span class="badge badge-warning">Low Stock</span>
                        @endif
                    @else
                        <span class="badge badge-danger">Out of Stock</span>
                    @endif
                </div>
                
                <div class="mb-lg">
                    <p class="text-secondary">{{ $product->description ?? 'No description available.' }}</p>
                </div>
                
                <div class="mb-lg">
                    <p><strong>Category:</strong> {{ $product->category->name ?? 'Uncategorized' }}</p>
                </div>
                
                @if($product->stock_quantity > 0)
                    <form wire:submit.prevent="addToCart" class="mb-lg">
                        <div class="flex gap-md items-center mb-md">
                            <label class="form-label" style="margin: 0;">Quantity:</label>
                            <input type="number" wire:model="quantity" min="1" max="{{ $product->stock_quantity }}" 
                                   class="form-input" style="width: 100px;">
                        </div>
                        @error('quantity') <p class="text-danger mb-sm">{{ $message }}</p> @enderror
                        
                        <button type="submit" class="btn btn-primary btn-lg w-full" wire:loading.attr="disabled">
                            <span wire:loading.remove>🛒 Add to Cart</span>
                            <span wire:loading>Adding...</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-xl">
                <h2 class="mb-lg">Related Products</h2>
                <div class="grid grid-cols-4 gap-md">
                    @foreach($relatedProducts as $related)
                        <div class="product-card">
                            <a href="/products/{{ $related->id }}" style="text-decoration: none; color: inherit;">
                                <img src="{{ $related->image_path ?? '/images/placeholder-product.png' }}" 
                                     alt="{{ $related->name }}" 
                                     class="product-image" 
                                     style="width: 100%; height: 150px; object-fit: cover;">
                                <div class="product-body" style="padding: 1rem;">
                                    <h4 class="product-title">{{ $related->name }}</h4>
                                    <div class="product-price">{{ format_currency($related->price) }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Reviews Section -->
        <div class="mt-xl">
            <h2 class="mb-lg">Customer Reviews</h2>
            
            @auth
                <div class="card mb-lg">
                    <h4 class="mb-md">Write a Review</h4>
                    <form wire:submit.prevent="submitReview">
                        <div class="form-group">
                            <label class="form-label">Rating</label>
                            <div class="flex gap-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <label style="cursor: pointer;">
                                        <input type="radio" wire:model="rating" value="{{ $i }}" style="display: none;">
                                        <span class="star-icon" style="font-size: 2rem; color: {{ $rating >= $i ? '#fbbf24' : 'var(--gray-300)' }};">★</span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Your Review</label>
                            <textarea wire:model="comment" class="form-textarea" rows="4" required></textarea>
                            @error('comment') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Submit Review</span>
                            <span wire:loading>Submitting...</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="alert alert-info">
                    <a href="/login">Login</a> to write a review
                </div>
            @endauth
            
            <div>
                @forelse($product->reviews()->latest()->get() as $review)
                    <div class="card mb-md">
                        <div class="flex justify-between items-start mb-sm">
                            <div>
                                <strong>{{ $review->user->name }}</strong>
                                <div class="product-rating">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < $review->rating)
                                            <span class="star">★</span>
                                        @else
                                            <span class="star empty">★</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <span class="text-secondary">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <p>{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-secondary">No reviews yet. Be the first to review!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
