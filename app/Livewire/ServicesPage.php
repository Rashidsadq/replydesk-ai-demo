<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class ServicesPage extends Component
{
    public $showModal = false;
    public $editingServiceId = null;
    public $name = '';
    public $name_ar = '';
    public $price = '';
    public $duration_minutes = 30;

    public function openAddModal()
    {
        $this->reset(['editingServiceId', 'name', 'name_ar', 'price', 'duration_minutes']);
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $service = Service::findOrFail($id);
        $this->editingServiceId = $service->id;
        $this->name = $service->name;
        $this->name_ar = $service->name_ar;
        $this->price = $service->price;
        $this->duration_minutes = $service->duration_minutes;
        $this->showModal = true;
    }

    public function saveService()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration_minutes' => 'required|integer',
        ]);

        if ($this->editingServiceId) {
            $service = Service::findOrFail($this->editingServiceId);
            $service->update([
                'name' => $this->name,
                'name_ar' => $this->name_ar,
                'price' => $this->price,
                'duration_minutes' => $this->duration_minutes,
            ]);
        } else {
            Service::create([
                'name' => $this->name,
                'name_ar' => $this->name_ar,
                'price' => $this->price,
                'duration_minutes' => $this->duration_minutes,
                'is_active' => true,
            ]);
        }

        $this->showModal = false;
    }

    public function toggleActive($id)
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);
    }

    public function render()
    {
        $services = Service::all();
        return view('livewire.services-page', [
            'services' => $services,
        ])->layout('components.layouts.app', ['title' => 'Services & Pricing — ReplyDesk AI']);
    }
}
