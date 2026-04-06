<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->when($this->role, fn($q) =>
                $q->where('role', $this->role)
            )
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-table', compact('users'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            session()->flash('error', 'Admin tidak bisa dihapus.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User berhasil dihapus.');
    }
}