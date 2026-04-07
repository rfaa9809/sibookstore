<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function show(string $slug)
    {
        $book = Book::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // Buku lain dari kategori yang sama (rekomendasi)
        $related = Book::with('category')
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->available()
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('books.show', compact('book', 'related'));
    }
}