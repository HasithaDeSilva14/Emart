<div>
    <div class="container" style="padding: 2rem 1.5rem;">
        <h1 class="mb-xl">Shopping Cart</h1>
        
        @if (session()->has('success'))
            <div class="alert alert-success mb-lg" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: var(--radius-md);">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- Cart Items -->
            <div style="grid-column: span 2;">
                @if (count($cartItems) > 0)
                    @foreach ($cartItems as $item)
                        <div class="card mb-md">
                            <div class="flex gap-lg">
                                <img src="{{ $item['product']['image_path'] ?? '/images/placeholder-product.png' }}" 
                                     alt="{{ $item['product']['name'] }}" 
                                     style="width: 120px; height: 120px; object-fit: cover; border-radius: var(--radius-md);">
                                
                                <div style="flex: 1;">
                                    <h4>{{ $item['product']['name'] }}</h4>
                                    <p class="text-secondary mb-md">{{ Str::limit($item['product']['description'] ?? '', 100) }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-md">
                                            <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                                    class="btn btn-sm btn-outline" 
                                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                                    wire:loading.attr="disabled">
                                                -
                                            </button>
                                            <span style="min-width: 40px; text-align: center; font-weight: 600;">
                                                {{ $item['quantity'] }}
                                            </span>
                                            <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                                    class="btn btn-sm btn-outline"
                                                    wire:loading.attr="disabled">
                                                +
                                            </button>
                                        </div>
                                        
                                        <div class="flex items-center gap-lg">
                                            <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                                                ${{ number_format($item['product']['price'] * $item['quantity'], 2) }}
                                            </span>
                                            <button wire:click="removeItem({{ $item['id'] }})" 
                                                    wire:confirm="Remove this item from cart?"
                                                    class="btn btn-sm btn-danger"
                                                    wire:loading.attr="disabled">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card text-center" style="padding: 3rem;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                        <h3>Your cart is empty</h3>
                        <p class="text-secondary mb-lg">Add some products to get started!</p>
                        <a href="/products" class="btn btn-primary">Browse Products</a>
                    </div>
                @endif
            </div>
            
            <!-- Cart Summary -->
            <div>
                <div class="card" style="position: sticky; top: 100px;">
                    <h3 class="mb-md">Order Summary</h3>
                    
                    <div class="flex justify-between mb-sm">
                        <span>Subtotal:</span>
                        <span>{{ format_currency($subtotal) }}</span>
                    </div>
                    
                    <div class="flex justify-between mb-sm">
                        <span>Tax (10%):</span>
                        <span>{{ format_currency($tax) }}</span>
                    </div>
                    
                    <div class="flex justify-between mb-md" style="padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 1.25rem; font-weight: 700;">
                        <span>Total:</span>
                        <span class="text-primary">{{ format_currency($total) }}</span>
                    </div>
                    
                    <a href="/checkout" 
                       class="btn btn-primary w-full mb-sm {{ count($cartItems) === 0 ? 'disabled' : '' }}">
                        Proceed to Checkout
                    </a>
                    <button wire:click="clearCart" 
                            wire:confirm="Clear all items from cart?"
                            class="btn btn-outline w-full"
                            {{ count($cartItems) === 0 ? 'disabled' : '' }}
                            wire:loading.attr="disabled">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
