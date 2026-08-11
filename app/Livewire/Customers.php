<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;

class Customers extends Component
{
    public $search = '';
    public $selectedCustomerId = null;

    public function selectCustomer($id)
    {
        $this->selectedCustomerId = $id;
    }

    public function closeDrawer()
    {
        $this->selectedCustomerId = null;
    }

    public function render()
    {
        $query = Customer::with(['conversations.messages', 'appointments.service', 'appointments.staff']);

        if (!empty(trim($this->search))) {
            $query->where('name', 'like', '%' . trim($this->search) . '%')
                  ->orWhere('phone', 'like', '%' . trim($this->search) . '%');
        }

        $customers = $query->get();
        $selectedCustomer = $this->selectedCustomerId 
            ? Customer::with(['conversations.messages', 'appointments.service', 'appointments.staff'])->find($this->selectedCustomerId)
            : null;

        return view('livewire.customers', [
            'customers' => $customers,
            'selectedCustomer' => $selectedCustomer,
        ])->layout('components.layouts.app', ['title' => 'Customers — ReplyDesk AI']);
    }
}
