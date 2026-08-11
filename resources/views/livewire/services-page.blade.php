@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isRtl ? 'قائمة الخدمات والأسعار' : 'Services & Pricing Menu' }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $isRtl ? 'إدارة أسعار الخدمات ومدة الجلسات المعرفات في الموظف الآلي.' : 'Configure services, prices (AED), and durations used by ReplyDesk AI.' }}</p>
        </div>

        <button wire:click="openAddModal" class="px-4 py-2.5 bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-purple-600/30 transition flex items-center gap-2">
            <span>+ Add New Service</span>
        </button>
    </div>

    <!-- Service Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($services as $svc)
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4 relative flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono text-slate-400 font-semibold">{{ $svc->duration_minutes }} mins</span>
                        <button wire:click="toggleActive({{ $svc->id }})" class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $svc->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                            {{ $svc->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mt-2">{{ $svc->name }}</h3>
                    @if($svc->name_ar)
                        <div class="text-xs text-slate-400 font-sans mt-0.5">{{ $svc->name_ar }}</div>
                    @endif
                    
                    <div class="mt-4">
                        <span class="text-2xl font-extrabold text-purple-700 font-mono">AED {{ number_format($svc->price, 0) }}</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">Used by AI Receptionist</span>
                    <button wire:click="openEditModal({{ $svc->id }})" class="text-xs font-bold text-purple-600 hover:text-purple-700">
                        Edit Service →
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4">
                <h3 class="text-lg font-bold text-slate-900">
                    {{ $editingServiceId ? 'Edit Salon Service' : 'Add New Service' }}
                </h3>

                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-bold text-slate-600 block mb-1">Service Name (English)</label>
                        <input type="text" wire:model="name" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-2.5">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-600 block mb-1">Arabic Name (Optional)</label>
                        <input type="text" wire:model="name_ar" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-2.5">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-bold text-slate-600 block mb-1">Price (AED)</label>
                            <input type="number" wire:model="price" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-mono">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-600 block mb-1">Duration (Minutes)</label>
                            <input type="number" wire:model="duration_minutes" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-mono">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button wire:click="saveService" class="flex-1 py-2.5 bg-purple-600 text-white font-bold text-xs rounded-xl shadow-md">
                        Save Service
                    </button>
                    <button wire:click="$set('showModal', false)" class="flex-1 py-2.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
