<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Halaman index kategori.
     * CRUD ditangani langsung oleh Livewire component Admin\CategoryTable.
     */
    public function index()
    {
        return view('admin.categories.index');
    }
}