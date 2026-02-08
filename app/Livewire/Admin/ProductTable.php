<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 15;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public $deleteId = null;

    public function confirmDelete($productId)
    {
        // kept for backward compatibility if template still references it
        // but strictly speaking not needed with native confirm
        $this->deleteId = $productId;
    }


    public function deleteProduct($id = null)
    {
        $idToDelete = $id ?? $this->deleteId;

        if (!$idToDelete) {
            return;
        }

        try {
            // Force disable foreign key checks to allow deletion
            // This is a "nuclear" option because standard cascading seems to be failing
            \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

            $product = Product::find($idToDelete);
            
            if (!$product) {
                session()->flash('error', 'Product not found!');
                \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
                return;
            }
            
            // Delete all related data manually to ensure no orphans
            \App\Models\Review::where('product_id', $idToDelete)->delete();
            \App\Models\Wishlist::where('product_id', $idToDelete)->delete();
            \App\Models\CartItem::where('product_id', $idToDelete)->delete();
            \App\Models\OrderItem::where('product_id', $idToDelete)->delete();

            // Delete product image if exists
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                @unlink(public_path($product->image_path));
            }
            
            $name = $product->name;
            $product->delete();
            
            \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

            session()->flash('success', "Product '{$name}' deleted successfully!");
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
            \Illuminate\Support\Facades\Log::error("Delete failed: " . $e->getMessage());
            session()->flash('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function toggleActive($productId)
    {
        $product = Product::find($productId);
        
        if ($product) {
            $product->update(['is_active' => !$product->is_active]);
            session()->flash('success', 'Product status updated!');
        }
    }

    public function render()
    {
        \Illuminate\Support\Facades\Log::info("Rendering ProductTable component");
        $query = Product::with('category');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.product-table', [
            'products' => $products,
        ])->layout('layouts.admin', ['title' => 'Manage Products - Admin']);
    }
}
