<?php

namespace App\Livewire;

use App\Models\BusinessSetting;
use Livewire\Component;

class BusinessSettings extends Component
{
    public $name = 'Elite Barber Dubai';
    public $phone = '+971 4 555 0188';
    public $location = 'Dubai Marina, Dubai';
    public $opening_hours = '10:00 AM - 10:00 PM';
    public $currency = 'AED';
    public $language = 'en';

    public function mount()
    {
        $setting = BusinessSetting::first();
        if ($setting) {
            $this->name = $setting->name;
            $this->phone = $setting->phone;
            $this->location = $setting->location;
            $this->opening_hours = $setting->opening_hours;
            $this->currency = $setting->currency;
            $this->language = session('locale', $setting->language);
        }
    }

    public function updatedLanguage($value)
    {
        session(['locale' => $value]);
    }

    public function saveSettings()
    {
        $setting = BusinessSetting::first();
        if ($setting) {
            $setting->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'location' => $this->location,
                'opening_hours' => $this->opening_hours,
                'currency' => $this->currency,
                'language' => $this->language,
            ]);
        }

        session(['locale' => $this->language]);
        session()->flash('status', 'Business settings saved successfully!');

        return redirect()->route('settings');
    }

    public function render()
    {
        return view('livewire.business-settings')->layout('components.layouts.app', ['title' => 'Business Settings — ReplyDesk AI']);
    }
}
