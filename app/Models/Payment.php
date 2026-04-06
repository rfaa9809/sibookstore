<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    // -------------------------------------------------------
    // Status & Method Constants
    // -------------------------------------------------------

    const STATUS_PENDING  = 'pending';
    const STATUS_UPLOADED = 'uploaded';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';

    const METHOD_TRANSFER        = 'transfer';
    const METHOD_VIRTUAL_ACCOUNT = 'virtual_account';
    const METHOD_COD             = 'cod';

    protected $fillable = [
        'order_id',
        'method',
        'status',
        'payment_proof',
        'amount',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount'  => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------
    // Status Helpers
    // -------------------------------------------------------

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isUploaded(): bool
    {
        return $this->status === self::STATUS_UPLOADED;
    }

    public function isVerified(): bool
    {
        return $this->status === self::STATUS_VERIFIED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING  => 'Menunggu Bukti',
            self::STATUS_UPLOADED => 'Bukti Diunggah',
            self::STATUS_VERIFIED => 'Terverifikasi',
            self::STATUS_REJECTED => 'Ditolak',
            default               => ucfirst($this->status),
        };
    }

    public function methodLabel(): string
    {
        return match ($this->method) {
            self::METHOD_TRANSFER        => 'Transfer Bank',
            self::METHOD_VIRTUAL_ACCOUNT => 'Virtual Account',
            self::METHOD_COD             => 'Cash on Delivery',
            default                      => ucfirst($this->method),
        };
    }

    public function formattedAmount(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}