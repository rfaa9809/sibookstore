<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('admin.payments.index');
    }

    /**
     * Admin memverifikasi bukti pembayaran.
     * 
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\RedirectResponse
     *
     * Updates payment status to 'verified' and sets 'paid_at' timestamp.
     * Also updates the related order status to 'verified' if it exists.
     * Possible statuses for Payment: STATUS_VERIFIED, STATUS_REJECTED.
     * Possible statuses for Order: STATUS_VERIFIED, STATUS_PENDING.
     */
    public function verify(Payment $payment)
    {
        $payment->update([
            'status'  => Payment::STATUS_VERIFIED,
            'paid_at' => now(),
        ]);
        if ($payment->order) {
            $payment->order->update(['status' => Order::STATUS_VERIFIED]);
        }

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Admin menolak bukti pembayaran dengan catatan alasan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\RedirectResponse
     *
     * Expects $request to have:
     *   - notes: string, required, max 500 chars.
     * Updates payment status to 'rejected' and order status to 'pending' if order exists.
     * Possible statuses for Payment: STATUS_VERIFIED, STATUS_REJECTED.
     * Possible statuses for Order: STATUS_VERIFIED, STATUS_PENDING.
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'notes' => ['required', 'string', 'max:500'],
        ]);

        $payment->update([
            'status' => Payment::STATUS_REJECTED,
        ]);

        if ($payment->order) {
            $payment->order->update(['status' => Order::STATUS_PENDING]);
        }

        return back()->with('success', 'Pembayaran ditolak. User perlu upload ulang bukti.');
    }
}