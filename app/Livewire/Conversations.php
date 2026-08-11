<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Conversations extends Component
{
    public $activeConversationId;
    public $replyText = '';

    public function mount($id = null)
    {
        if ($id) {
            $this->activeConversationId = $id;
        } else {
            $first = Conversation::first();
            $this->activeConversationId = $first ? $first->id : null;
        }
    }

    public function selectConversation($id)
    {
        $this->activeConversationId = $id;
    }

    public function toggleHumanTakeover()
    {
        if (!$this->activeConversationId) {
            return;
        }

        $conversation = Conversation::findOrFail($this->activeConversationId);
        
        if ($conversation->status === 'ai_active') {
            $conversation->update(['status' => 'human_handling']);
            
            // Add system announcement message
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'staff',
                'sender_name' => 'System Alert',
                'content' => '⚠️ AI assistant paused. You are now handling this conversation.',
            ]);
        } else {
            $conversation->update(['status' => 'ai_active']);
            
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'ai',
                'sender_name' => 'ReplyDesk AI',
                'content' => '🤖 AI receptionist resumed. I am now automatically assisting the customer.',
            ]);
        }
    }

    public function sendStaffReply()
    {
        if (empty(trim($this->replyText)) || !$this->activeConversationId) {
            return;
        }

        $conversation = Conversation::findOrFail($this->activeConversationId);
        
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'staff',
            'sender_name' => 'Ahmed Hassan (Staff)',
            'content' => trim($this->replyText),
        ]);

        $conversation->update([
            'last_message' => trim($this->replyText),
            'last_message_at' => now(),
        ]);

        $this->replyText = '';
    }

    public function render()
    {
        $conversations = Conversation::with('customer')->orderBy('updated_at', 'desc')->get();
        $activeConversation = $this->activeConversationId 
            ? Conversation::with(['customer', 'messages'])->find($this->activeConversationId) 
            : null;

        return view('livewire.conversations', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
        ])->layout('components.layouts.app', ['title' => 'Conversations Inbox — ReplyDesk AI']);
    }
}
