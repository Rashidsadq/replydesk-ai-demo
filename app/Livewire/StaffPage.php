<?php

namespace App\Livewire;

use App\Models\Staff;
use Livewire\Component;

class StaffPage extends Component
{
    public function toggleStatus($id)
    {
        $staff = Staff::findOrFail($id);
        $next = match($staff->status) {
            'available' => 'busy',
            'busy' => 'off',
            default => 'available',
        };
        $staff->update(['status' => $next]);
    }

    public function render()
    {
        $staffMembers = Staff::withCount('appointments')->get();
        return view('livewire.staff-page', [
            'staffMembers' => $staffMembers,
        ])->layout('components.layouts.app', ['title' => 'Barbers & Staff — ReplyDesk AI']);
    }
}
