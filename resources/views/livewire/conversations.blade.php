@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="h-[calc(100vh-6.5rem)] flex flex-col gap-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isRtl ? 'صندوق محادثات الواتساب' : 'WhatsApp Conversations Inbox' }}</h1>
            <p class="text-xs text-slate-500">{{ $isRtl ? 'إدارة محادثات العملاء بالذكاء الاصطناعي أو التدخل البشري المباشر.' : 'Monitor live AI receptionist interactions or manually take over customer chats.' }}</p>
        </div>
        <a href="{{ route('demo') }}" class="px-3.5 py-2 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200 text-xs font-bold transition">
            {{ $isRtl ? 'فتح المحاكي الفوري' : 'Open WhatsApp Simulator →' }}
        </a>
    </div>

    <!-- Main Inbox Box -->
    <div class="flex-1 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex overflow-hidden min-h-0">
        
        <!-- Left: Conversations List -->
        <div class="w-80 sm:w-96 border-r border-slate-200 flex flex-col bg-slate-50/50 shrink-0">
            <div class="p-3.5 border-b border-slate-200 bg-white">
                <input type="text" placeholder="Search conversations..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
            </div>

            <div class="flex-1 overflow-y-auto divide-y divide-slate-100">
                @foreach($conversations as $conv)
                    <button wire:click="selectConversation({{ $conv->id }})" 
                            class="w-full text-left p-3.5 flex items-start gap-3 transition-colors {{ $activeConversationId == $conv->id ? 'bg-purple-50/80 border-l-4 border-purple-600' : 'hover:bg-slate-100/80' }}">
                        <img src="{{ $conv->customer->avatar_url }}" alt="" class="w-10 h-10 rounded-full object-cover shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="text-xs font-bold text-slate-800 truncate">{{ $conv->customer->name }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $conv->last_message_at ? $conv->last_message_at->format('H:i') : '' }}</span>
                            </div>
                            <p class="text-xs text-slate-500 truncate">{{ $conv->last_message }}</p>
                            
                            <div class="mt-2 flex items-center justify-between">
                                @if($conv->status === 'ai_active')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> AI Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Human Handling
                                    </span>
                                @endif
                                
                                @if($conv->unread_count > 0)
                                    <span class="bg-purple-600 text-white font-bold text-[10px] px-1.5 py-0.2 rounded-full font-mono">
                                        {{ $conv->unread_count }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Right: Thread & Takeover Controls -->
        <div class="flex-1 flex flex-col bg-slate-50/30 min-w-0">
            @if($activeConversation)
                <!-- Top Control Bar -->
                <div class="h-16 px-6 bg-white border-b border-slate-200 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3">
                        <img src="{{ $activeConversation->customer->avatar_url }}" alt="" class="w-9 h-9 rounded-full object-cover ring-2 ring-slate-200">
                        <div>
                            <div class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <span>{{ $activeConversation->customer->name }}</span>
                                <span class="text-xs text-slate-400 font-normal">({{ $activeConversation->customer->phone }})</span>
                            </div>
                            <div class="text-[11px] text-slate-500 font-medium">
                                Status: 
                                @if($activeConversation->status === 'ai_active')
                                    <span class="text-emerald-600 font-bold">🤖 AI Receptionist Handling</span>
                                @else
                                    <span class="text-amber-600 font-bold">👨‍💼 Human Staff Takeover</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Take Over / Return Button -->
                    <div>
                        @if($activeConversation->status === 'ai_active')
                            <button wire:click="toggleHumanTakeover" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-300 font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                                <span>👨‍💼 Take Over Conversation</span>
                            </button>
                        @else
                            <button wire:click="toggleHumanTakeover" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center gap-2">
                                <span>🤖 Return to AI Receptionist</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Status Announcement Banner -->
                @if($activeConversation->status === 'human_handling')
                    <div class="bg-amber-500 text-slate-900 px-4 py-2.5 text-xs font-bold text-center border-b border-amber-600 flex items-center justify-center gap-2">
                        <span>⚠️ AI assistant paused. You are now handling this conversation manually.</span>
                    </div>
                @endif

                <!-- Messages Thread -->
                <div class="flex-1 p-4 overflow-y-auto space-y-3">
                    @foreach($activeConversation->messages as $msg)
                        @if($msg->sender_type === 'customer')
                            <div class="flex justify-start">
                                <div class="bg-white text-slate-800 rounded-2xl rounded-tl-none p-3.5 max-w-[75%] shadow-sm border border-slate-200">
                                    <div class="text-[10px] font-bold text-slate-400 mb-1">{{ $msg->sender_name }}</div>
                                    <div class="text-xs leading-relaxed">{!! nl2br(e($msg->content)) !!}</div>
                                    <div class="text-[9px] text-slate-400 text-right mt-1 font-mono">{{ $msg->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        @elseif($msg->sender_type === 'ai')
                            <div class="flex justify-end">
                                <div class="bg-purple-900 text-white rounded-2xl rounded-tr-none p-3.5 max-w-[75%] shadow-sm border border-purple-700/50">
                                    <div class="text-[10px] font-bold text-purple-200 mb-1 flex items-center gap-1">
                                        <span>🤖 ReplyDesk AI</span>
                                    </div>
                                    <div class="text-xs leading-relaxed">{!! nl2br(e($msg->content)) !!}</div>
                                    <div class="text-[9px] text-purple-300 text-right mt-1 font-mono">{{ $msg->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-center my-2">
                                <div class="bg-amber-100 text-amber-900 font-semibold px-3 py-1 rounded-full text-[11px] border border-amber-200 shadow-sm">
                                    {{ $msg->content }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Staff Reply Form -->
                <div class="p-3 bg-white border-t border-slate-200 flex items-center gap-2 shrink-0">
                    <input type="text" 
                           wire:model="replyText"
                           wire:keydown.enter="sendStaffReply"
                           placeholder="{{ $activeConversation->status === 'human_handling' ? 'Type your human response to customer...' : 'Type a reply (takes over conversation automatically)...' }}" 
                           class="flex-1 text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                    <button wire:click="sendStaffReply" class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold transition">
                        Send Staff Reply
                    </button>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-slate-400 text-sm">
                    Select a conversation to view thread.
                </div>
            @endif
        </div>
    </div>
</div>
