<div>
    <div class="container" style="padding: 2rem 1.5rem;">
        <div class="flex justify-between items-center mb-xl">
            <h1>Manage Products</h1>
            <a href="/admin/products/create" class="btn btn-primary">➕ Add New Product</a>
        </div>
        
        @if (session()->has('success'))
            <div class="alert alert-success mb-lg" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: var(--radius-md);">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Search -->
        <div class="card mb-lg">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input" placeholder="Search products...">
        </div>
        
        <!-- Products Table -->
        @if($products->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                                <th class="p-sm">ID</th>
                                <th class="p-sm">Name</th>
                                <th class="p-sm">Category</th>
                                <th class="p-sm">Price</th>
                                <th class="p-sm">Stock</th>
                                <th class="p-sm">Status</th>
                                <th class="p-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr wire:key="{{ $product->id }}" style="border-bottom: 1px solid var(--border-color);">
                                    <td class="p-sm">{{ $product->id }}</td>
                                    <td class="p-sm">{{ $product->name }}</td>
                                    <td class="p-sm">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="p-sm">{{ format_currency($product->price) }}</td>
                                    <td class="p-sm">
                                        @if($product->isLowStock())
                                            <span class="badge badge-warning">{{ $product->stock_quantity }}</span>
                                        @else
                                            {{ $product->stock_quantity }}
                                        @endif
                                    </td>
                                    <td class="p-sm">
                                        <button wire:click="toggleActive({{ $product->id }})" 
                                                class="badge {{ $product->is_active ? 'badge-success' : 'badge-secondary' }}"
                                                style="cursor: pointer; border: none;">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td class="p-sm">
                                        <div class="flex gap-sm">
                                            <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-outline">Edit</a>
                                            <button 
                                                type="button"
                                                wire:confirm="Are you sure you want to delete this product?"
                                                wire:click="deleteProduct({{ $product->id }})"
                                                wire:loading.attr="disabled"
                                                class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-lg">
                    {{ $products->links() }}
                </div>
            </div>
        @else
            <div class="card text-center" style="padding: 3rem;">
                <p class="text-secondary">No products found</p>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation using Alpine.js -->

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.1s ease;
}

.modal-content {
    background: var(--background);
    border-radius: var(--radius-lg);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    width: 90%;
    max-width: 600px;
    animation: slideUp 0.3s ease;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
}

.modal-close {
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: var(--text-secondary);
    line-height: 1;
    padding: 0;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
    transition: all 0.2s;
}

.modal-close:hover {
    background: var(--background-secondary);
    color: var(--text-primary);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</div>
