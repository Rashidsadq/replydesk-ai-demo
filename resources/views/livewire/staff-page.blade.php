@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isRtl ? 'طاقم الحلاقين والموظفين' : 'Barbers & Staff Roster' }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $isRtl ? 'إدارة تواجد الحلاقين وجداول العمل للمساعد الذكي.' : 'Manage barber profiles, working hours, and assignment statuses.' }}</p>
        </div>
    </div>

    <!-- Staff Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($staffMembers as $staff)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-5 relative hover:shadow-md transition">
                <!-- Top Header & Avatar -->
                <div class="flex items-center gap-4">
                    <img src="{{ $staff->avatar_url }}" alt="{{ $staff->name }}" class="w-14 h-14 rounded-full object-cover ring-4 ring-purple-500/20">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">{{ $staff->name }}</h3>
                        <div class="text-xs text-purple-600 font-semibold">{{ $staff->role }}</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Hours: {{ $staff->working_hours }}</div>
                    </div>
                </div>

                <!-- Assigned Services Badges -->
                <div>
                    <div class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-2">Capabilities</div>
                    <div class="flex flex-wrap gap-1.5">
                        @if(is_array($staff->services))
                            @foreach($staff->services as $svc)
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold">
                                    {{ $svc }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Stats & Status Toggle -->
                <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-400 block uppercase font-bold">Appointments Today</span>
                        <span class="text-base font-extrabold text-slate-900 font-mono">{{ $staff->appointments_count }} Booked</span>
                    </div>

                    <button wire:click="toggleStatus({{ $staff->id }})" 
                            class="px-3 py-1.5 rounded-xl text-xs font-extrabold transition {{ $staff->status === 'available' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : ($staff->status === 'busy' ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-slate-200 text-slate-600') }}">
                        @if($staff->status === 'available')
                            🟢 Available
                        @elseif($staff->status === 'busy')
                            🟡 Busy Now
                        @else
                            ⚪ Off Duty
                        @endif
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
