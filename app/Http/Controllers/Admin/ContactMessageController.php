<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::with('user')
            ->latest()
            ->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        return back();
    }


    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}