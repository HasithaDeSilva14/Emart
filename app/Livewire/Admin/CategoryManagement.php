<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class CategoryManagement extends Component
{
    public $categories;
    public $name = '';
    public $slug = '';
    public $editingId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::withCount('products')->orderBy('name')->get();
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        if ($this->editingId) {
            $this->update();
        } else {
            $this->create();
        }
    }

    public function create()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        session()->flash('success', 'Category created successfully!');
        $this->reset(['name', 'slug']);
        $this->loadCategories();
    }

    public function edit($categoryId)
    {
        $category = Category::find($categoryId);
        
        if ($category) {
            $this->editingId = $category->id;
            $this->name = $category->name;
            $this->slug = $category->slug;
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->editingId,
        ]);

        $category = Category::find($this->editingId);
        
        if ($category) {
            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
            ]);

            session()->flash('success', 'Category updated successfully!');
            $this->reset(['name', 'slug', 'editingId']);
            $this->loadCategories();
        }
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'slug', 'editingId']);
    }

    public function delete($categoryId)
    {
        $category = Category::find($categoryId);
        
        if ($category) {
            if ($category->products()->count() > 0) {
                session()->flash('error', 'Cannot delete category with products!');
            } else {
                $category->delete();
                session()->flash('success', 'Category deleted successfully!');
                $this->loadCategories();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.category-management')->layout('layouts.admin', ['title' => 'Manage Categories - Admin']);
    }
}
