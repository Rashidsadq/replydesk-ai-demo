@php
    $isRtl = session('locale') === 'ar';
@endphp

<div x-data="{ 
        isPlaying: false, 
        isTyping: false, 
        currentStep: @entangle('currentStep'),
        
        async runFullDemo() {
            if (this.isPlaying) return;
            this.isPlaying = true;
            this.currentStep = 1;
            
            await $wire.triggerAutoBooking();
            
            this.isTyping = true;
            await new Promise(r => setTimeout(r, 1200));
            this.isTyping = false;
            
            this.currentStep = 2;
            this.isTyping = true;
            await new Promise(r => setTimeout(r, 1000));
            this.isTyping = false;

            this.currentStep = 3;
            this.isPlaying = false;
        }
    }" 
     class="h-[calc(100vh-6.5rem)] flex flex-col gap-4">
    
    <!-- Top Guided Demo Progress Header -->
    <div class="bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 text-white rounded-2xl p-4 sm:p-5 border border-purple-800/40 shadow-xl space-y-4">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-purple-900/60 pb-3">
            <div class="flex items-center gap-3">
                <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-purple-600 text-white tracking-wider uppercase font-mono shadow-md">
                    {{ $isRtl ? 'عرض مباشر' : 'LIVE DEMO' }}
                </span>
                <div>
                    <h2 class="text-base font-extrabold text-white">
                        {{ $isRtl ? 'ReplyDesk AI — مسار موظف الاستقبال الآلي' : 'ReplyDesk AI WhatsApp Receptionist Flow' }}
                    </h2>
                    <p class="text-xs text-purple-200">
                        {{ $isRtl ? 'شاهد كيف يجيب موظف الذكاء الاصطناعي على استفسارات العملاء ويتحقق من المواعيد ويحجز تلقائياً.' : 'Watch the AI answer customer inquiries, verify slot availability, and book appointments automatically.' }}
                    </p>
                </div>
            </div>

            <!-- Auto Demo Play Trigger -->
            <div class="flex items-center gap-2">
                <button @click="runFullDemo()" 
                        :disabled="isPlaying"
                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-extrabold transition shadow-lg shadow-purple-600/40 flex items-center gap-2 disabled:opacity-50">
                    <svg x-show="!isPlaying" class="w-4 h-4 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                    </svg>
                    <span x-text="isPlaying ? '{{ $isRtl ? "جاري تشغيل العرض..." : "Playing Live Demo..." }}' : '{{ $isRtl ? "▶ تشغيل العرض التلقائي" : "▶ Run Guided Auto Demo" }}'"></span>
                </button>
            </div>
        </div>

        <!-- 3 Step Progress Indicator Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <!-- Step 1 -->
            <div class="p-3 rounded-xl border transition-all flex items-center gap-3"
                 :class="currentStep == 1 ? 'bg-purple-900/80 border-purple-500 text-white shadow-md' : 'bg-slate-900/60 border-slate-800 text-slate-400'">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center font-bold text-xs shrink-0"
                     :class="currentStep == 1 ? 'bg-purple-600 text-white' : 'bg-slate-800 text-slate-400'">
                    1
                </div>
                <div>
                    <div class="font-bold">{{ $isRtl ? 'الخطوة 1 — سؤال العميل' : 'Step 1 — Customer asks' }}</div>
                    <div class="text-[10px] opacity-80">{{ $isRtl ? '"كم سعر الحلاقة؟"' : '"How much is a haircut?"' }}</div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="p-3 rounded-xl border transition-all flex items-center gap-3"
                 :class="currentStep == 2 ? 'bg-purple-900/80 border-purple-500 text-white shadow-md' : 'bg-slate-900/60 border-slate-800 text-slate-400'">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center font-bold text-xs shrink-0"
                     :class="currentStep == 2 ? 'bg-purple-600 text-white' : 'bg-slate-800 text-slate-400'">
                    2
                </div>
                <div>
                    <div class="font-bold">{{ $isRtl ? 'الخطوة 2 — رد الذكاء الاصطناعي' : 'Step 2 — AI responds' }}</div>
                    <div class="text-[10px] opacity-80">{{ $isRtl ? 'تقديم السعر وفحص المواعيد' : 'Pricing & checks barber slots' }}</div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="p-3 rounded-xl border transition-all flex items-center gap-3"
                 :class="currentStep == 3 ? 'bg-emerald-950/90 border-emerald-500 text-emerald-200 shadow-md ring-2 ring-emerald-500/30' : 'bg-slate-900/60 border-slate-800 text-slate-400'">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center font-bold text-xs shrink-0"
                     :class="currentStep == 3 ? 'bg-emerald-500 text-white' : 'bg-slate-800 text-slate-400'">
                    ✓
                </div>
                <div>
                    <div class="font-bold">{{ $isRtl ? 'الخطوة 3 — تأكيد الحجز' : 'Step 3 — Appointment booked' }}</div>
                    <div class="text-[10px] opacity-80">{{ $isRtl ? 'مزامنة فورية مع لوحة التحكم' : 'Synced with Salon Dashboard' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Simulation Action Badges -->
    <div class="bg-white rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center justify-between flex-wrap gap-2">
        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
            {{ $isRtl ? 'محاكاة استفسار (اضغط للاختبار):' : 'Simulate Custom Inquiry (Click to test):' }}
        </div>
        <div class="flex flex-wrap gap-2">
            <button wire:click="simulateMessage('{{ $isRtl ? "كم سعر الحلاقة؟" : "How much is a haircut?" }}')" 
                    class="px-3 py-1.5 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200 text-xs font-semibold transition">
                💬 "{{ $isRtl ? 'كم سعر الحلاقة؟' : 'How much is a haircut?' }}"
            </button>
            <button wire:click="simulateMessage('{{ $isRtl ? "أرغب في الحجز غداً الساعة 6 مساءً" : "I want to book tomorrow at 6 PM" }}')" 
                    class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200 text-xs font-semibold transition">
                💬 "{{ $isRtl ? 'أرغب في الحجز غداً الساعة 6' : 'Book tomorrow at 6 PM' }}"
            </button>
            <button wire:click="simulateMessage('6:00 PM')" 
                    class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-300 text-xs font-extrabold transition">
                ✅ {{ $isRtl ? 'اختيار 6:00 مساءً' : 'Select "6:00 PM"' }}
            </button>
            <button wire:click="simulateMessage('{{ $isRtl ? "أريد التحدث مع موظف" : "Can I speak to someone?" }}')" 
                    class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 text-xs font-semibold transition">
                👨‍💼 {{ $isRtl ? 'التدخل البشري' : 'Human Takeover' }}
            </button>
        </div>
    </div>

    <!-- Main Messaging App Interface -->
    <div class="flex-1 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex overflow-hidden min-h-0">
        
        <!-- Left: Conversations Sidebar -->
        <div class="w-80 border-r border-slate-200 flex flex-col bg-slate-50/50 shrink-0 hidden md:flex">
            <div class="p-3.5 border-b border-slate-200 bg-white">
                <h3 class="text-sm font-bold text-slate-800">{{ $isRtl ? 'محادثات العملاء التجريبية' : 'Demo Customer Conversations' }}</h3>
                <p class="text-[11px] text-slate-500">Elite Barber Dubai Receptionist</p>
            </div>

            <div class="flex-1 overflow-y-auto divide-y divide-slate-100">
                @foreach($conversations as $conv)
                    <button wire:click="selectConversation({{ $conv->id }})" 
                            class="w-full text-left p-3.5 flex items-start gap-3 transition-colors {{ $activeConversationId == $conv->id ? 'bg-purple-50/80 border-l-4 border-purple-600' : 'hover:bg-slate-100/80' }}">
                        <img src="{{ $conv->customer->avatar_url }}" alt="" class="w-10 h-10 rounded-full object-cover shrink-0 ring-2 ring-slate-200">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="text-xs font-bold text-slate-800 truncate">{{ $conv->customer->name }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $conv->last_message_at ? $conv->last_message_at->format('H:i') : '' }}</span>
                            </div>
                            <p class="text-xs text-slate-500 truncate">{{ $conv->last_message }}</p>
                            
                            <div class="mt-1.5 flex items-center justify-between">
                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> AI Active
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $conv->customer->phone }}</span>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Right: Chat Area -->
        <div class="flex-1 flex flex-col bg-[#f0f2f5]/40 min-w-0 relative">
            @if($activeConversation)
                <!-- Chat Window Topbar -->
                <div class="h-16 px-4 bg-slate-900 text-white flex items-center justify-between shrink-0 shadow-md">
                    <div class="flex items-center gap-3">
                        <img src="{{ $activeConversation->customer->avatar_url }}" alt="" class="w-9 h-9 rounded-full object-cover ring-2 ring-purple-400/40">
                        <div>
                            <div class="text-sm font-bold text-white flex items-center gap-2">
                                <span>{{ $activeConversation->customer->name }}</span>
                                <span class="text-xs text-slate-400 font-normal">({{ $activeConversation->customer->phone }})</span>
                            </div>
                            <div class="text-[11px] text-emerald-400 flex items-center gap-1.5 font-medium">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>ReplyDesk AI Receptionist Active</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('dashboard', ['highlight' => 'latest']) }}" class="text-xs text-purple-200 hover:text-white px-3 py-1.5 rounded-xl bg-purple-900/60 border border-purple-700/50 font-bold transition">
                        {{ $isRtl ? 'عرض لوحة التحكم ←' : 'View Dashboard →' }}
                    </a>
                </div>

                <!-- Chat Stream -->
                <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:16px_16px]">
                    <div class="text-center my-2">
                        <span class="text-[10px] font-semibold bg-slate-200/80 text-slate-600 px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $isRtl ? 'عرض تفاعلي • موظف استقبال صالون النخبة باربر دبي' : 'Interactive Demo • Elite Barber Dubai Receptionist' }}
                        </span>
                    </div>

                    @foreach($activeConversation->messages as $msg)
                        @if($msg->sender_type === 'customer')
                            <!-- Customer Bubble -->
                            <div class="flex justify-start">
                                <div class="bg-white text-slate-800 rounded-2xl rounded-tl-none p-3.5 max-w-[80%] shadow-sm border border-slate-200/80">
                                    <div class="text-[10px] font-bold text-slate-400 mb-1">{{ $msg->sender_name }}</div>
                                    <div class="text-xs leading-relaxed font-medium">{!! nl2br(e($msg->content)) !!}</div>
                                    <div class="text-[9px] text-slate-400 text-right mt-1 font-mono">{{ $msg->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        @else
                            <!-- AI Receptionist Bubble -->
                            <div class="flex justify-end">
                                <div class="bg-purple-900 text-white rounded-2xl rounded-tr-none p-4 max-w-[85%] shadow-lg border border-purple-700/50 space-y-2">
                                    <div class="flex items-center justify-between text-[10px] text-purple-200 border-b border-purple-800/80 pb-1.5">
                                        <span class="font-bold flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            ReplyDesk AI Receptionist
                                        </span>
                                        <span class="text-[9px] bg-purple-800 px-2 py-0.5 rounded font-mono text-purple-200">{{ $isRtl ? 'رد آلي' : 'Auto-Reply' }}</span>
                                    </div>

                                    <div class="text-xs leading-relaxed">{!! nl2br(e($msg->content)) !!}</div>

                                    <!-- Booking Confirmation Card -->
                                    @if($msg->is_booking_confirmation || str_contains($msg->content, 'booked') || str_contains($msg->content, 'حجز'))
                                        <div class="mt-3 bg-gradient-to-br from-slate-900 to-purple-950 rounded-2xl p-4 border-2 border-emerald-500/60 shadow-xl space-y-3 text-left">
                                            <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-sm">✓</div>
                                                    <div>
                                                        <span class="text-xs font-extrabold text-emerald-400 uppercase tracking-wider block">
                                                            {{ $isRtl ? 'تم تأكيد الموعد' : 'Appointment Confirmed' }}
                                                        </span>
                                                        <span class="text-[10px] text-slate-300">
                                                            {{ $isRtl ? 'تمت المزامنة بنجاح مع تقويم الصالون' : 'Successfully synced to salon calendar' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="text-[10px] font-mono bg-slate-950 px-2 py-1 rounded text-emerald-300 border border-emerald-500/30">#BK-8492</span>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3 text-xs bg-slate-950/70 p-3 rounded-xl border border-slate-800">
                                                <div>
                                                    <span class="text-slate-400 text-[10px] block uppercase font-bold">{{ $isRtl ? 'الخدمة' : 'Service' }}</span>
                                                    <span class="font-extrabold text-white text-sm">{{ $isRtl ? 'قص شعر' : 'Haircut' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-slate-400 text-[10px] block uppercase font-bold">{{ $isRtl ? 'الحلاق' : 'Barber Staff' }}</span>
                                                    <span class="font-extrabold text-white text-sm">Ahmed Hassan</span>
                                                </div>
                                                <div>
                                                    <span class="text-slate-400 text-[10px] block uppercase font-bold">{{ $isRtl ? 'الموعد' : 'Time Slot' }}</span>
                                                    <span class="font-extrabold text-emerald-300 text-sm">{{ $isRtl ? 'اليوم، 6:00 مساءً' : 'Today, 6:00 PM' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-slate-400 text-[10px] block uppercase font-bold">{{ $isRtl ? 'السعر' : 'Price' }}</span>
                                                    <span class="font-extrabold text-white font-mono text-sm">80 AED</span>
                                                </div>
                                            </div>

                                            <!-- Direct Link to Dashboard -->
                                            <div class="pt-1 flex items-center justify-between">
                                                <span class="text-[10px] text-slate-400">{{ $isRtl ? 'تمت الإضافة إلى لوحة تحكم المتجر' : 'Received by Business Dashboard' }}</span>
                                                <a href="{{ route('dashboard', ['highlight' => 'latest']) }}" 
                                                   class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-slate-950 font-black text-xs rounded-xl shadow-lg transition flex items-center gap-1.5">
                                                    <span>{{ $isRtl ? 'عرض في لوحة التحكم ←' : 'View in Dashboard →' }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="text-[9px] text-purple-300 text-right mt-1 font-mono flex items-center justify-end gap-1">
                                        <span>{{ $msg->created_at->format('H:i') }}</span>
                                        <span>✓✓</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <!-- Typing Indicator -->
                    <div x-show="isTyping" x-transition class="flex justify-end my-2">
                        <div class="bg-purple-900/80 text-white rounded-2xl rounded-tr-none px-4 py-2.5 shadow-md flex items-center gap-2">
                            <span class="text-xs font-semibold text-purple-200">
                                {{ $isRtl ? 'ReplyDesk AI يكتب الآن' : 'ReplyDesk AI is typing' }}
                            </span>
                            <div class="flex gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-300 animate-bounce"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-300 animate-bounce [animation-delay:0.2s]"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-300 animate-bounce [animation-delay:0.4s]"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Input Form -->
                <div class="p-3 bg-white border-t border-slate-200 flex items-center gap-2 shrink-0">
                    <input type="text" 
                           wire:model="customMessage" 
                           wire:keydown.enter="sendMessage"
                           placeholder="{{ $isRtl ? 'اكتب رسالة للعميل (مثال: كم سعر قص الشعر؟)...' : 'Type a customer message (e.g. Can I book tomorrow at 6 PM?)...' }}" 
                           class="flex-1 text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                    <button wire:click="sendMessage" class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold transition shadow-md">
                        {{ $isRtl ? 'إرسال' : 'Send Message' }}
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
