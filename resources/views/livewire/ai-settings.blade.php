@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isRtl ? 'إعدادات موظف الاستقبال الآلي' : 'AI Receptionist Configuration' }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $isRtl ? 'ضبط صلاحيات وقواعد عمل الذكاء الاصطناعي على واتساب.' : 'Configure automated AI receptionist behavior, system rules, and prompt restrictions.' }}</p>
        </div>

        <button wire:click="saveSettings" class="px-4 py-2.5 bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-purple-600/30 transition">
            Save AI Configurations
        </button>
    </div>

    @if(session('status'))
        <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-bold">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left 7 Cols: Capabilities & System Rules -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Business Info Snapshot -->
            <div class="bg-slate-900 text-white rounded-2xl p-5 border border-slate-800 shadow-sm space-y-2">
                <div class="text-xs font-bold text-purple-400 uppercase tracking-wider">Active Salon Context</div>
                <div class="text-lg font-bold">Elite Barber Dubai</div>
                <div class="text-xs text-slate-300 grid grid-cols-2 gap-2 pt-1 font-mono">
                    <div>📍 Location: Dubai Marina, Dubai</div>
                    <div>🕒 Hours: 10:00 AM - 10:00 PM</div>
                    <div>📞 Phone: +971 4 555 0188</div>
                    <div>💵 Currency: AED</div>
                </div>
            </div>

            <!-- Capabilities Checkboxes -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-900">AI Receptionist Capabilities</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <label wire:click="toggleCapability('service_questions')" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                        <input type="checkbox" {{ ($capabilities['service_questions'] ?? false) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded">
                        <span class="font-bold text-slate-800">Answer service questions</span>
                    </label>

                    <label wire:click="toggleCapability('pricing_questions')" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                        <input type="checkbox" {{ ($capabilities['pricing_questions'] ?? false) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded">
                        <span class="font-bold text-slate-800">Answer pricing questions</span>
                    </label>

                    <label wire:click="toggleCapability('check_availability')" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                        <input type="checkbox" {{ ($capabilities['check_availability'] ?? false) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded">
                        <span class="font-bold text-slate-800">Check appointment availability</span>
                    </label>

                    <label wire:click="toggleCapability('book_appointments')" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                        <input type="checkbox" {{ ($capabilities['book_appointments'] ?? false) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded">
                        <span class="font-bold text-slate-800">Book appointments</span>
                    </label>

                    <label wire:click="toggleCapability('answer_faqs')" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                        <input type="checkbox" {{ ($capabilities['answer_faqs'] ?? false) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded">
                        <span class="font-bold text-slate-800">Answer FAQs</span>
                    </label>

                    <label wire:click="toggleCapability('transfer_to_staff')" class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                        <input type="checkbox" {{ ($capabilities['transfer_to_staff'] ?? false) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 rounded">
                        <span class="font-bold text-slate-800">Transfer conversations to staff</span>
                    </label>
                </div>
            </div>

            <!-- AI Rules Configuration -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-900">Safety & Execution Rules</h3>
                
                <div class="space-y-2">
                    @foreach($rules as $index => $rule)
                        <div class="p-3 rounded-xl bg-purple-50/60 border border-purple-200 text-xs font-semibold text-purple-900 flex items-center justify-between">
                            <span>"{{ $rule }}"</span>
                            <button wire:click="removeRule({{ $index }})" class="text-rose-600 hover:text-rose-800 font-bold px-2">✕</button>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="text" wire:model="newRule" placeholder="Add custom AI rule (e.g. Always offer tea or coffee on arrival)..." class="flex-1 text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                    <button wire:click="addRule" class="px-3.5 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl">Add Rule</button>
                </div>
            </div>
        </div>

        <!-- Right 5 Cols: Live AI Sandbox Preview Panel -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 mb-1">AI Preview Playground</h3>
                <p class="text-xs text-slate-500 mb-4">Test how your configured AI receptionist responds to inquiries.</p>

                <div class="space-y-3">
                    <div>
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Test Inquiry</label>
                        <input type="text" wire:model="testQuery" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 font-medium">
                    </div>

                    <button wire:click="testAi" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl transition shadow-md">
                        ⚡ Run AI Test Reply
                    </button>

                    @if($testReply)
                        <div class="mt-4 p-4 rounded-2xl bg-purple-900 text-white border border-purple-700/50 space-y-2">
                            <div class="text-[10px] font-bold text-purple-300 uppercase">AI Receptionist Reply</div>
                            <div class="text-xs leading-relaxed font-medium">{{ $testReply }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 font-medium">
                ✅ AI behavior verified against Elite Barber Dubai guidelines.
            </div>
        </div>
    </div>
</div>
