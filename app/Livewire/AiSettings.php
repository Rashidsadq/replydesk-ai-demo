<?php

namespace App\Livewire;

use App\Models\BusinessSetting;
use Livewire\Component;

class AiSettings extends Component
{
    public $ai_enabled = true;
    public $capabilities = [];
    public $rules = [];
    public $newRule = '';
    public $testQuery = 'How much is a haircut?';
    public $testReply = '';

    public function mount()
    {
        $settings = BusinessSetting::first();
        if ($settings) {
            $this->ai_enabled = $settings->ai_enabled;
            $this->capabilities = $settings->capabilities ?? [
                'service_questions' => true,
                'pricing_questions' => true,
                'check_availability' => true,
                'book_appointments' => true,
                'answer_faqs' => true,
                'transfer_to_staff' => true,
            ];
            $this->rules = $settings->rules ?? [
                'Only provide information configured by the business.',
                'Never invent prices or appointment availability.',
                'If unsure, transfer the customer to staff.',
            ];
        }
    }

    public function toggleCapability($key)
    {
        $this->capabilities[$key] = !($this->capabilities[$key] ?? false);
    }

    public function addRule()
    {
        if (!empty(trim($this->newRule))) {
            $this->rules[] = trim($this->newRule);
            $this->newRule = '';
        }
    }

    public function removeRule($index)
    {
        unset($this->rules[$index]);
        $this->rules = array_values($this->rules);
    }

    public function testAi()
    {
        $lower = mb_strtolower($this->testQuery);
        if (str_contains($lower, 'price') || str_contains($lower, 'haircut') || str_contains($lower, 'cost')) {
            $this->testReply = "Our haircut is AED 80 and takes around 30 minutes. Would you like to book an appointment?";
        } elseif (str_contains($lower, 'open') || str_contains($lower, 'hours')) {
            $this->testReply = "Elite Barber Dubai is open 10:00 AM - 10:00 PM daily at Dubai Marina.";
        } else {
            $this->testReply = "Thank you! I am configured to follow Elite Barber Dubai rules strictly.";
        }
    }

    public function saveSettings()
    {
        $settings = BusinessSetting::first();
        if ($settings) {
            $settings->update([
                'ai_enabled' => $this->ai_enabled,
                'capabilities' => $this->capabilities,
                'rules' => $this->rules,
            ]);
        }
        session()->flash('status', 'AI Settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.ai-settings')->layout('components.layouts.app', ['title' => 'AI Settings & Rules — ReplyDesk AI']);
    }
}
