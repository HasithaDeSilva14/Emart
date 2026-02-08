<div>
    <div class="container" style="padding: 2rem 1.5rem; max-width: 800px;">
        <h1 class="mb-xl">{{ $product ? 'Edit Product' : 'Add New Product' }}</h1>
        
        <div class="card">
            <form wire:submit="save">
                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" wire:model.live.debounce.300ms="name" class="form-input" required>
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Slug *</label>
                    <input type="text" wire:model="slug" class="form-input" required>
                    <small class="text-secondary">URL-friendly version of the name</small>
                    @error('slug') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea wire:model="description" class="form-textarea" rows="4"></textarea>
                    @error('description') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-md">
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <input 
                            type="text" 
                            wire:model="category_name" 
                            class="form-input" 
                            list="categoryList"
                            placeholder="Type category name"
                            required
                        >
                        <datalist id="categoryList">
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}">
                            @endforeach
                        </datalist>
                        <small class="text-secondary">Select existing or enter new category</small>
                        @error('category_name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Price *</label>
                        <input type="number" wire:model="price" class="form-input" step="0.01" min="0" required>
                        @error('price') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-md">
                    <div class="form-group">
                        <label class="form-label">Stock Quantity *</label>
                        <input type="number" wire:model="stock_quantity" class="form-input" min="0" required>
                        @error('stock_quantity') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Low Stock Threshold *</label>
                        <input type="number" wire:model="low_stock_threshold" class="form-input" min="0" required>
                        @error('low_stock_threshold') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Product Image</label>
                    <input type="file" wire:model="image" class="form-input" accept="image/*">
                    @error('image') <span class="form-error">{{ $message }}</span> @enderror
                    
                    @if ($image)
                        <div class="mt-sm">
                            <p class="text-secondary">Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" style="max-width: 200px; border-radius: var(--radius-md);">
                        </div>
                    @elseif ($image_path)
                        <div class="mt-sm">
                            <p class="text-secondary">Current image:</p>
                            <img src="{{ $image_path }}" style="max-width: 200px; border-radius: var(--radius-md);">
                        </div>
                    @endif
                    
                    <div wire:loading wire:target="image" class="mt-sm text-secondary">
                        Uploading...
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="flex items-center gap-sm">
                        <input type="checkbox" wire:model="is_active" class="form-checkbox">
                        <span class="form-label" style="margin-bottom: 0;">Active (visible to customers)</span>
                    </label>
                </div>
                
                <div class="flex gap-md justify-end">
                    <a href="/admin/products" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $product ? 'Update Product' : 'Create Product' }}</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
