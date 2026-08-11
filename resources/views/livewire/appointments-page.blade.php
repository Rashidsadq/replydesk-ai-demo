@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isRtl ? 'جدول المواعيد والتقويم' : 'Appointments & Salon Calendar' }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $isRtl ? 'متابعة المواعيد المحجوزة عبر الذكاء الاصطناعي وتأكيدها أو تعديلها.' : 'Agenda view for today and upcoming salon appointments.' }}</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-slate-200 shadow-sm text-xs font-semibold">
            <button wire:click="filterTab('all')" class="px-3 py-1.5 rounded-lg transition {{ $activeTab === 'all' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                All
            </button>
            <button wire:click="filterTab('confirmed')" class="px-3 py-1.5 rounded-lg transition {{ $activeTab === 'confirmed' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Confirmed
            </button>
            <button wire:click="filterTab('pending')" class="px-3 py-1.5 rounded-lg transition {{ $activeTab === 'pending' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Pending
            </button>
            <button wire:click="filterTab('cancelled')" class="px-3 py-1.5 rounded-lg transition {{ $activeTab === 'cancelled' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Cancelled
            </button>
        </div>
    </div>

    <!-- Day View Schedule Timeline -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($appointments as $app)
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4 relative hover:shadow-md transition">
                <!-- Top Slot & Status -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold font-mono text-purple-700">{{ $app->time_slot }}</span>
                        @if($app->booked_by_ai)
                            <span class="text-[10px] bg-purple-50 text-purple-700 px-2 py-0.5 rounded font-bold border border-purple-200">
                                ⚡ AI Booked
                            </span>
                        @endif
                    </div>

                    @if($app->status === 'confirmed')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            Confirmed
                        </span>
                    @elseif($app->status === 'pending')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                            Pending Approval
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                            Cancelled
                        </span>
                    @endif
                </div>

                <!-- Customer Details -->
                <div class="flex items-center gap-3">
                    <img src="{{ $app->customer->avatar_url }}" alt="" class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-200">
                    <div>
                        <div class="text-sm font-bold text-slate-900">{{ $app->customer->name }}</div>
                        <div class="text-xs text-slate-500 font-mono">{{ $app->customer->phone }}</div>
                    </div>
                </div>

                <!-- Service & Barber Info -->
                <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 space-y-1.5 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Service:</span>
                        <span class="font-bold text-slate-800">{{ $app->service->name }} ({{ $app->service->duration_minutes }}m)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Barber:</span>
                        <span class="font-bold text-slate-800">{{ $app->staff->name }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-slate-200/60">
                        <span class="text-slate-400">Price:</span>
                        <span class="font-bold text-emerald-600 font-mono">AED {{ number_format($app->service->price, 0) }}</span>
                    </div>
                </div>

                <!-- Actions Bar -->
                <div class="flex items-center gap-2 pt-1">
                    @if($app->status !== 'confirmed')
                        <button wire:click="updateStatus({{ $app->id }}, 'confirmed')" class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl transition shadow-sm">
                            Confirm
                        </button>
                    @endif
                    <button wire:click="openReschedule({{ $app->id }})" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition border border-slate-200">
                        Reschedule
                    </button>
                    @if($app->status !== 'cancelled')
                        <button wire:click="updateStatus({{ $app->id }}, 'cancelled')" class="py-2 px-3 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl transition border border-rose-200">
                            Cancel
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center text-slate-400 border border-slate-200/80">
                No appointments found for this filter tab.
            </div>
        @endforelse
    </div>

    <!-- Reschedule Modal -->
    @if($showRescheduleModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4">
                <h3 class="text-lg font-bold text-slate-900">Reschedule Appointment Slot</h3>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Select New Time Slot</label>
                    <select wire:model="newTimeSlot" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-2.5">
                        <option value="11:00 AM">11:00 AM</option>
                        <option value="1:30 PM">1:30 PM</option>
                        <option value="3:00 PM">3:00 PM</option>
                        <option value="4:00 PM">4:00 PM</option>
                        <option value="5:30 PM">5:30 PM</option>
                        <option value="7:00 PM">7:00 PM</option>
                        <option value="8:30 PM">8:30 PM</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <button wire:click="saveReschedule" class="flex-1 py-2.5 bg-purple-600 text-white font-bold text-xs rounded-xl shadow-md">
                        Save New Slot
                    </button>
                    <button wire:click="$set('showRescheduleModal', false)" class="flex-1 py-2.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
