@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="max-w-4xl space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isRtl ? 'إعدادات المتجر والصالون' : 'Business Settings & Profile' }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $isRtl ? 'تحديث معلومات الفرع، ساعات العمل، واللغة المفضلة.' : 'Update salon profile information, operating hours, currency, and primary language.' }}</p>
        </div>

        <button wire:click="saveSettings" class="px-4 py-2.5 bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-purple-600/30 transition">
            Save Profile Settings
        </button>
    </div>

    @if(session('status'))
        <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-bold">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-6">
        
        <!-- Language Switcher Highlight Section -->
        <div class="p-4 bg-purple-50 rounded-xl border border-purple-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-purple-900 flex items-center gap-2">
                    <span>🌐 Language & Layout Direction</span>
                    @if($isRtl)
                        <span class="bg-purple-600 text-white px-2 py-0.5 rounded text-[10px]">RTL Mode Active</span>
                    @endif
                </div>
                <p class="text-xs text-purple-700 mt-0.5">Toggle between English and Arabic to test complete right-to-left layout transformations.</p>
            </div>

            <div class="flex items-center gap-2">
                <select wire:model.live="language" class="text-xs font-bold bg-white border border-purple-300 rounded-xl px-3 py-2 text-purple-900 focus:outline-none">
                    <option value="en">English (LTR)</option>
                    <option value="ar">العربية (RTL)</option>
                </select>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <label class="font-bold text-slate-700 block mb-1">Business Name</label>
                <input type="text" wire:model="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-medium">
            </div>

            <div>
                <label class="font-bold text-slate-700 block mb-1">WhatsApp Phone Number</label>
                <input type="text" wire:model="phone" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-mono font-medium">
            </div>

            <div>
                <label class="font-bold text-slate-700 block mb-1">Location & Address</label>
                <input type="text" wire:model="location" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-medium">
            </div>

            <div>
                <label class="font-bold text-slate-700 block mb-1">Opening Hours</label>
                <input type="text" wire:model="opening_hours" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-medium">
            </div>

            <div>
                <label class="font-bold text-slate-700 block mb-1">Default Currency</label>
                <input type="text" wire:model="currency" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-mono font-bold text-purple-700">
            </div>
        </div>
    </div>
</div>
