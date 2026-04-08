<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING   = 'pending';
    const STATUS_PAID      = 'paid';
    const STATUS_VERIFIED  = 'verified';
    const STATUS_SHIPPED   = 'shipped';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_address',
        'recipient_name',
        'recipient_phone',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }


    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $date      = now()->format('Ymd');
            $lastOrder = static::whereDate('created_at', today())->lockForUpdate()->count();
            $sequence  = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT);

            $order->order_number = "ORD-{$date}-{$sequence}";
        });
    }

    public function formattedTotal(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isVerified(): bool
    {
        return $this->status === self::STATUS_VERIFIED;
    }

    public function isShipped(): bool
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => 'Menunggu Pembayaran',
            self::STATUS_PAID      => 'Bukti Dikirim',
            self::STATUS_VERIFIED  => 'Pembayaran Terverifikasi',
            self::STATUS_SHIPPED   => 'Sedang Dikirim',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default                => ucfirst($this->status),
        };
    }

    
    public function statusColor(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => 'yellow',
            self::STATUS_PAID      => 'blue',
            self::STATUS_VERIFIED  => 'indigo',
            self::STATUS_SHIPPED   => 'purple',
            self::STATUS_COMPLETED => 'green',
            self::STATUS_CANCELLED => 'red',
            default                => 'gray',
        };
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}