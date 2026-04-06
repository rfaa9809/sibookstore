<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'author',
        'publisher',
        'published_year',
        'price',
        'stock',
        'description',
        'cover_image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    // -------------------------------------------------------
    // Auto-generate slug dari title saat create/update
    // -------------------------------------------------------

    protected static function booted(): void
    {
        static::creating(function (Book $book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });

        static::updating(function (Book $book) {
            if ($book->isDirty('title')) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    // -------------------------------------------------------
    // Scopes
    // -------------------------------------------------------

    /**
     * Scope pencarian buku berdasarkan judul, penulis, atau penerbit.
     * Penggunaan: Book::search('laravel')->get()
     */
    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('author', 'like', "%{$keyword}%")
              ->orWhere('publisher', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope untuk filter buku yang masih tersedia (stock > 0).
     * Penggunaan: Book::available()->get()
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function formattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}