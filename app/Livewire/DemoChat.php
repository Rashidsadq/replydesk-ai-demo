<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Service;
use App\Models\Staff;
use App\Services\DemoAiService;
use Carbon\Carbon;
use Livewire\Component;

class DemoChat extends Component
{
    public $activeConversationId;
    public $customMessage = '';
    public $currentStep = 1; // 1: Customer asks, 2: AI responds, 3: Booked
    public $isAutoPlaying = false;
    public $lastBookedId = null;

    public function mount($conversationId = null)
    {
        if ($conversationId) {
            $this->activeConversationId = $conversationId;
        } else {
            $defaultConv = Conversation::first();
            $this->activeConversationId = $defaultConv ? $defaultConv->id : null;
        }
    }

    public function selectConversation($id)
    {
        $this->activeConversationId = $id;
    }

    public function simulateMessage(DemoAiService $aiService, string $text)
    {
        if (!$this->activeConversationId) {
            return;
        }

        $conversation = Conversation::findOrFail($this->activeConversationId);
        $msg = $aiService->respond($conversation, $text);

        if (str_contains(mb_strtolower($text), 'how much') || str_contains(mb_strtolower($text), 'price')) {
            $this->currentStep = 1;
        } elseif (str_contains(mb_strtolower($text), '6 pm') || str_contains(mb_strtolower($text), 'tomorrow')) {
            $this->currentStep = 2;
        } elseif (in_array(mb_strtolower(trim($text)), ['6:00 pm', '6:00', '6pm', '6:30 pm', '6:30'])) {
            $this->currentStep = 3;
            $latestApp = Appointment::orderBy('id', 'desc')->first();
            if ($latestApp) {
                $this->lastBookedId = $latestApp->id;
            }
        }

        $this->customMessage = '';
    }

    public function triggerAutoBooking(DemoAiService $aiService)
    {
        if (!$this->activeConversationId) {
            return;
        }

        $conversation = Conversation::findOrFail($this->activeConversationId);
        
        // Reset conversation messages for clean automated playback
        $conversation->messages()->delete();

        // Step 1: Customer asks price
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_name' => $conversation->customer->name,
            'content' => 'Hi, how much is a haircut?',
            'created_at' => Carbon::now()->subMinutes(3),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Hi 👋 Our haircut is AED 80 and takes around 30 minutes. Would you like to book an appointment?',
            'created_at' => Carbon::now()->subMinutes(3)->addSeconds(2),
        ]);

        // Step 2: Customer specifies time
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_name' => $conversation->customer->name,
            'content' => 'Yes, tomorrow at 6 PM.',
            'created_at' => Carbon::now()->subMinutes(2),
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'I have 6:00 PM and 6:30 PM available today with Ahmed Hassan. Which one would you prefer?',
            'created_at' => Carbon::now()->subMinutes(2)->addSeconds(2),
        ]);

        // Step 3: Customer picks 6:00 PM
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_name' => $conversation->customer->name,
            'content' => '6:00 PM',
            'created_at' => Carbon::now()->subMinute(),
        ]);

        $service = Service::where('name', 'Haircut')->first() ?? Service::first();
        $staff = Staff::where('name', 'Ahmed Hassan')->first() ?? Staff::first();

        $app = Appointment::create([
            'customer_id' => $conversation->customer_id,
            'service_id' => $service->id,
            'staff_id' => $staff->id,
            'appointment_date' => Carbon::today(),
            'time_slot' => '6:00 PM',
            'status' => 'confirmed',
            'booked_by_ai' => true,
        ]);

        $this->lastBookedId = $app->id;

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Perfect! Your haircut is booked for today at 6:00 PM with Ahmed Hassan. ✅',
            'is_booking_confirmation' => true,
            'booking_details' => [
                'service' => 'Haircut',
                'price' => '80 AED',
                'duration' => '30 mins',
                'time' => 'Today, 6:00 PM',
                'staff' => 'Ahmed Hassan',
                'status' => 'Confirmed',
            ],
            'created_at' => Carbon::now(),
        ]);

        $conversation->update([
            'last_message' => 'Perfect! Your haircut is booked for today at 6:00 PM with Ahmed Hassan. ✅',
            'last_message_at' => Carbon::now(),
            'status' => 'ai_active',
            'summary' => $conversation->customer->name . ' — Booked Haircut 6:00 PM — AI handled',
        ]);

        $this->currentStep = 3;
    }

    public function sendMessage(DemoAiService $aiService)
    {
        if (empty(trim($this->customMessage)) || !$this->activeConversationId) {
            return;
        }

        $conversation = Conversation::findOrFail($this->activeConversationId);
        $aiService->respond($conversation, trim($this->customMessage));
        $this->customMessage = '';
    }

    public function render()
    {
        $conversations = Conversation::with('customer')->get();
        $activeConversation = $this->activeConversationId 
            ? Conversation::with(['customer', 'messages'])->find($this->activeConversationId) 
            : null;

        return view('livewire.demo-chat', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
        ])->layout('components.layouts.app', ['title' => 'Guided Live WhatsApp Demo — ReplyDesk AI']);
    }
}
