<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use App\Models\Category;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BookTable extends Component
{
    use WithPagination, WithFileUploads;

    public string $search      = '';
    public string $filterCategory = '';

    // Form fields
    #[Rule('required|exists:categories,id')]
    public ?int $category_id = null;

    #[Rule('required|string|max:255')]
    public string $title = '';

    #[Rule('required|string|max:255')]
    public string $author = '';

    #[Rule('nullable|string|max:255')]
    public string $publisher = '';

    #[Rule('nullable|digits:4')]
    public string $published_year = '';

    #[Rule('required|numeric|min:0')]
    public string $price = '';

    #[Rule('required|integer|min:0')]
    public string $stock = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('nullable|image|max:2048')]
    public $cover_image = null;

    // State
    public ?int $editingId = null;
    public bool $showModal = false;
    public ?string $existingCover = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // -------------------------------------------------------
    // CRUD Actions
    // -------------------------------------------------------

    public function openCreate(): void
    {
        $this->reset(['category_id', 'title', 'author', 'publisher', 'published_year',
                      'price', 'stock', 'description', 'cover_image', 'editingId', 'existingCover']);
        $this->showModal = true;
    }

    public function openEdit(Book $book): void
    {
        $this->editingId       = $book->id;
        $this->category_id     = $book->category_id;
        $this->title           = $book->title;
        $this->author          = $book->author;
        $this->publisher       = $book->publisher ?? '';
        $this->published_year  = $book->published_year ?? '';
        $this->price           = (string) $book->price;
        $this->stock           = (string) $book->stock;
        $this->description     = $book->description ?? '';
        $this->existingCover   = $book->cover_image;
        $this->cover_image     = null;
        $this->showModal       = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'category_id'    => $this->category_id,
            'title'          => $this->title,
            'author'         => $this->author,
            'publisher'      => $this->publisher,
            'published_year' => $this->published_year ?: null,
            'price'          => $this->price,
            'stock'          => $this->stock,
            'description'    => $this->description,
        ];

        // Upload cover image jika ada
        if ($this->cover_image) {
            $data['cover_image'] = $this->cover_image->store('books/covers', 'public');
        }

        if ($this->editingId) {
            Book::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Buku berhasil diperbarui.');
        } else {
            Book::create($data);
            session()->flash('success', 'Buku berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete(Book $book): void
    {
        if ($book->orderItems()->exists()) {
            session()->flash('error', 'Buku tidak bisa dihapus karena sudah ada di histori pesanan.');
            return;
        }

        $book->delete();
        session()->flash('success', 'Buku berhasil dihapus.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['category_id', 'title', 'author', 'publisher', 'published_year',
                      'price', 'stock', 'description', 'cover_image', 'editingId', 'existingCover']);
        $this->resetValidation();
    }

    // -------------------------------------------------------
    // Render
    // -------------------------------------------------------

    public function render()
    {
        $books = Book::query()
            ->with('category')
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->filterCategory, fn ($q) => $q->where('category_id', $this->filterCategory))
            ->latest()
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('livewire.admin.book-table', compact('books', 'categories'));
    }
}