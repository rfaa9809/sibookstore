<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class BookCatalog extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $category    = '';
    public string $sortBy      = 'latest'; // latest | price_asc | price_desc | title_asc

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingCategory(): void { $this->resetPage(); }
    public function updatingSortBy(): void   { $this->resetPage(); }

    public function render()
    {
        $books = Book::query()
            ->with('category')
            ->available()
            ->when($this->search,   fn ($q) => $q->search($this->search))
            ->when($this->category, fn ($q) => $q->where('category_id', $this->category))
            ->when($this->sortBy === 'price_asc',  fn ($q) => $q->orderBy('price'))
            ->when($this->sortBy === 'price_desc', fn ($q) => $q->orderByDesc('price'))
            ->when($this->sortBy === 'title_asc',  fn ($q) => $q->orderBy('title'))
            ->when($this->sortBy === 'latest',     fn ($q) => $q->latest())
            ->paginate(12);

        $categories = Category::withCount('books')->get();

        return view('livewire.book-catalog', compact('books', 'categories'));
    }
}