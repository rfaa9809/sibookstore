<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithPagination;

    public string $search = '';

    // Form fields
    #[Rule('required|string|max:100')]
    public string $name = '';

    #[Rule('nullable|string|max:500')]
    public string $description = '';

    // State
    public ?int $editingId = null;
    public bool $showModal = false;

    // Reset pagination saat search berubah
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // -------------------------------------------------------
    // CRUD Actions
    // -------------------------------------------------------

    public function openCreate(): void
    {
        $this->reset(['name', 'description', 'editingId']);
        $this->showModal = true;
    }

    public function openEdit(Category $category): void
    {
        $this->editingId   = $category->id;
        $this->name        = $category->name;
        $this->description = $category->description ?? '';
        $this->showModal   = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name'        => $this->name,
            'description' => $this->description,
        ];

        if ($this->editingId) {
            Category::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Kategori berhasil diperbarui.');
        } else {
            Category::create($data);
            session()->flash('success', 'Kategori berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['name', 'description', 'editingId']);
    }

    public function delete(Category $category): void
    {
        // Cek apakah masih ada buku dalam kategori ini
        if ($category->books()->exists()) {
            session()->flash('error', 'Kategori tidak bisa dihapus karena masih memiliki buku.');
            return;
        }

        $category->delete();
        session()->flash('success', 'Kategori berhasil dihapus.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['name', 'description', 'editingId']);
        $this->resetValidation();
    }

    // -------------------------------------------------------
    // Render
    // -------------------------------------------------------

    public function render()
    {
        $categories = Category::query()
            ->withCount('books')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.category-table', compact('categories'));
    }
}