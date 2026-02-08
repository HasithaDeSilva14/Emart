<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProductForm extends Component
{
    use WithFileUploads;

    public ?Product $product = null;
    public $name = '';
    public $slug = '';
    public $description = '';
    public $category_name = '';
    public $price = '';
    public $stock_quantity = '';
    public $low_stock_threshold = 10;
    public $image_path = '';
    public $image = null;
    public $is_active = true;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . ($this->product->id ?? 'NULL'),
            'description' => 'nullable|string',
            'category_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];
    }

    public function mount(?Product $product = null)
    {
        if ($product && $product->exists) {
            $this->product = $product;
            $this->name = $product->name;
            $this->slug = $product->slug;
            $this->description = $product->description;
            $this->category_name = $product->category->name ?? '';
            $this->price = $product->price;
            $this->stock_quantity = $product->stock_quantity;
            $this->low_stock_threshold = $product->low_stock_threshold;
            $this->image_path = $product->image_path;
            $this->is_active = $product->is_active;
        }
    }

    public function updatedName($value)
    {
        // Auto-generate slug from name if creating new product
        if (!$this->product) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate();

        // Find or create category
        $category = Category::firstOrCreate(
            ['name' => $this->category_name],
            ['slug' => Str::slug($this->category_name)]
        );

        // Handle image upload
        $imagePath = $this->image_path;
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            $imagePath = '/storage/' . $imagePath;
        }

        $data = [
            'category_id' => $category->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'low_stock_threshold' => $this->low_stock_threshold,
            'image_path' => $imagePath,
            'is_active' => $this->is_active,
        ];

        if ($this->product) {
            $this->product->update($data);
            session()->flash('success', 'Product updated successfully!');
        } else {
            Product::create($data);
            session()->flash('success', 'Product created successfully!');
        }

        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();

        $title = $this->product ? 'Edit Product - Admin' : 'Add Product - Admin';

        return view('livewire.admin.product-form', [
            'categories' => $categories,
        ])->layout('layouts.admin', ['title' => $title]);
    }
}
