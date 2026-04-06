<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price'    => 'decimal:2',
        ];
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    /**
     * Subtotal untuk item ini berdasarkan harga snapshot × quantity.
     * Menggunakan $this->price (snapshot), bukan $this->book->price,
     * agar tidak terpengaruh perubahan harga buku di kemudian hari.
     */
    public function subtotal(): float
    {
        return $this->price * $this->quantity;
    }

    public function formattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}