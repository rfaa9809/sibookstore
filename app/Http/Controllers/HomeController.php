<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Halaman utama — hanya kirim data kategori untuk filter.
     * Data buku dan pencarian ditangani Livewire BookCatalog component.
     */
    public function __invoke()
    {
        $categories = Category::withCount('books')->orderBy('name')->get();

        return view('home', compact('categories'));
    }
}