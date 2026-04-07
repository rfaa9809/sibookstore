<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CheckoutForm extends Component
{
    // Step: 1 = alamat, 2 = metode bayar, 3 = konfirmasi
    public int $step = 1;

    // Step 1 — Alamat
    #[Rule('required|string|max:100')]
    public string $recipientName = '';

    #[Rule('required|string|max:20')]
    public string $recipientPhone = '';

    #[Rule('required|string|max:255')]
    public string $addressStreet = '';

    #[Rule('required|string|max:100')]
    public string $addressCity = '';

    #[Rule('required|string|max:100')]
    public string $addressProvince = '';

    #[Rule('required|string|max:10')]
    public string $addressPostal = '';

    public string $notes = '';

    // Step 2 — Metode pembayaran
    #[Rule('required|in:transfer,virtual_account,cod')]
    public string $paymentMethod = '';

    // Data cart (di-load di mount)
    public $cartItems;
    public float $total = 0;

    public function mount(): void
    {
        $this->cartItems = CartItem::with('book')
            ->where('user_id', Auth::id())
            ->get();

        $this->total = $this->cartItems->sum(fn ($item) => $item->subtotal());

        // Pre-fill nama dari profil user
        $this->recipientName = Auth::user()->name;
    }

    // -------------------------------------------------------
    // Step navigation
    // -------------------------------------------------------

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validateOnly('recipientName');
            $this->validateOnly('recipientPhone');
            $this->validateOnly('addressStreet');
            $this->validateOnly('addressCity');
            $this->validateOnly('addressProvince');
            $this->validateOnly('addressPostal');
        }

        if ($this->step === 2) {
            $this->validateOnly('paymentMethod');
        }

        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    // -------------------------------------------------------
    // Place order
    // -------------------------------------------------------

    public function placeOrder(): void
    {
        $this->validate([
            'recipientName'   => 'required|string|max:100',
            'recipientPhone'  => 'required|string|max:20',
            'addressStreet'   => 'required|string|max:255',
            'addressCity'     => 'required|string|max:100',
            'addressProvince' => 'required|string|max:100',
            'addressPostal'   => 'required|string|max:10',
            'paymentMethod'   => 'required|in:transfer,virtual_account,cod',
        ]);

        // Cek ulang stock sebelum order
        foreach ($this->cartItems as $item) {
            if ($item->book->stock < $item->quantity) {
                $this->addError('stock', "Stok buku \"{$item->book->title}\" tidak mencukupi.");
                $this->step = 1;
                return;
            }
        }

        DB::transaction(function () {
            $shippingAddress = implode(', ', array_filter([
                $this->addressStreet,
                $this->addressCity,
                $this->addressProvince,
                $this->addressPostal,
            ]));

            // Buat order
            $order = Order::create([
                'user_id'          => Auth::id(),
                'status'           => Order::STATUS_PENDING,
                'total_amount'     => $this->total,
                'shipping_address' => $shippingAddress,
                'recipient_name'   => $this->recipientName,
                'recipient_phone'  => $this->recipientPhone,
                'notes'            => $this->notes,
            ]);

            // Buat order items + kurangi stok
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id'  => $item->book_id,
                    'quantity' => $item->quantity,
                    'price'    => $item->book->price,
                ]);

                // Kurangi stok
                $item->book->decrement('stock', $item->quantity);
            }

            // Buat record payment
            Payment::create([
                'order_id' => $order->id,
                'method'   => $this->paymentMethod,
                'status'   => Payment::STATUS_PENDING,
                'amount'   => $this->total,
            ]);

            // Kosongkan cart
            CartItem::where('user_id', Auth::id())->delete();

            $this->dispatch('cart-updated');

            // Redirect ke halaman order detail
            $this->redirectRoute('orders.show', $order->id);
        });
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    public function fullAddress(): string
    {
        return implode(', ', array_filter([
            $this->addressStreet,
            $this->addressCity,
            $this->addressProvince,
            $this->addressPostal,
        ]));
    }

    public function render()
    {
        return view('livewire.checkout-form');
    }
}