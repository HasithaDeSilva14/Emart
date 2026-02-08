<div>
    <div class="container" style="padding: 2rem 1.5rem;">
        <h1 class="mb-xl">Manage Categories</h1>
        
        @if (session()->has('success'))
            <div class="alert alert-success mb-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="alert alert-error mb-lg">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="grid grid-cols-2 gap-lg">
            <!-- Category Form -->
            <div class="card">
                <h3 class="mb-md">{{ $editingId ? 'Edit Category' : 'Add New Category' }}</h3>
                
                <form wire:submit="save">
                    <div class="form-group">
                        <label class="form-label">Category Name *</label>
                        <input type="text" wire:model.live.debounce.300ms="name" class="form-input" required>
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Slug *</label>
                        <input type="text" wire:model="slug" class="form-input" required>
                        @error('slug') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex gap-md">
                        @if($editingId)
                            <button type="button" wire:click="cancelEdit" class="btn btn-outline">Cancel</button>
                        @endif
                        <button type="submit" class="btn btn-primary w-full">
                            {{ $editingId ? 'Update Category' : 'Create Category' }}
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Categories List -->
            <div class="card">
                <h3 class="mb-md">Existing Categories</h3>
                
                @if($categories->count() > 0)
                    <div style="max-height: 500px; overflow-y: auto;">
                        @foreach($categories as $category)
                            <div class="flex justify-between items-center p-sm" style="border-bottom: 1px solid var(--border-color);">
                                <div>
                                    <strong>{{ $category->name }}</strong>
                                    <p class="text-secondary" style="font-size: 0.875rem;">
                                        {{ $category->products_count }} product(s)
                                    </p>
                                </div>
                                <div class="flex gap-sm">
                                    <button wire:click="edit({{ $category->id }})" class="btn btn-sm btn-outline">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $category->id }})" 
                                            wire:confirm="Are you sure you want to delete this category?"
                                            class="btn btn-sm btn-danger"
                                            {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-secondary">No categories yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
