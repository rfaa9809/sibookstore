<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrderDetail extends Component
{
    use WithFileUploads;

    public Order $order;
    public $paymentProof = null;
    public bool $showUploadForm = false;

    public function mount(Order $order): void
    {
        // Pastikan order milik user yang login
        abort_if($order->user_id !== Auth::id(), 403);

        $this->order = $order->load(['orderItems.book', 'payment']);
    }

    public function uploadProof(): void
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048',
        ]);

        $path = $this->paymentProof->store('payments/proofs', 'public');

        $this->order->payment->update([
            'payment_proof' => $path,
            'status'        => Payment::STATUS_UPLOADED,
        ]);

        $this->order->update(['status' => Order::STATUS_PAID]);

        // Reload order
        $this->order = $this->order->fresh(['orderItems.book', 'payment']);

        $this->showUploadForm = false;
        $this->paymentProof   = null;

        session()->flash('success', 'Bukti pembayaran berhasil diunggah! Admin akan memverifikasi segera.');
    }

    public function render()
    {
        return view('livewire.order-detail');
    }
}