<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentTable extends Component
{
    use WithPagination;

    public string $filterStatus = 'uploaded'; // default tampilkan yang butuh diverifikasi

    // State modal reject
    public bool   $showRejectModal = false;
    public ?int   $rejectingId     = null;
    public string $rejectNotes     = '';

    public function updatingFilterStatus(): void { $this->resetPage(); }

    // -------------------------------------------------------
    // Actions
    // -------------------------------------------------------

    public function verify(Payment $payment): void
    {
        $payment->update([
            'status'  => Payment::STATUS_VERIFIED,
            'paid_at' => now(),
        ]);

        $payment->order->update(['status' => Order::STATUS_VERIFIED]);

        session()->flash('success', "Pembayaran order {$payment->order->order_number} berhasil diverifikasi.");
    }

    public function openReject(int $paymentId): void
    {
        $this->rejectingId   = $paymentId;
        $this->rejectNotes   = '';
        $this->showRejectModal = true;
    }

    public function confirmReject(): void
    {
        $this->validate([
            'rejectNotes' => 'required|string|min:10|max:500',
        ]);

        $payment = Payment::findOrFail($this->rejectingId);

        $payment->update([
            'status' => Payment::STATUS_REJECTED,
            'notes'  => $this->rejectNotes,
        ]);

        $payment->order->update(['status' => Order::STATUS_PENDING]);

        $this->showRejectModal = false;
        $this->reset(['rejectingId', 'rejectNotes']);

        session()->flash('success', 'Pembayaran ditolak. User akan diminta upload ulang.');
    }

    public function closeRejectModal(): void
    {
        $this->showRejectModal = false;
        $this->reset(['rejectingId', 'rejectNotes']);
        $this->resetValidation();
    }

    // -------------------------------------------------------
    // Render
    // -------------------------------------------------------

    public function render()
    {
        $payments = Payment::query()
            ->with(['order.user'])
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.payment-table', compact('payments'));
    }
}