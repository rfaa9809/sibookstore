<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Halaman index buku.
     * CRUD ditangani langsung oleh Livewire component Admin\BookTable.
     */
    public function index()
    {
        return view('admin.books.index');
    }
}