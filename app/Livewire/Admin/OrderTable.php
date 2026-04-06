<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $filterStatus = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function render()
    {
        $orders = Order::query()
            ->with(['user', 'payment'])
            ->when($this->search, function ($q) {
                $q->where('order_number', 'like', "%{$this->search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.order-table', compact('orders'));
    }
}