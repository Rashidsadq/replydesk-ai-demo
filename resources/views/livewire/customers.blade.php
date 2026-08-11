@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isRtl ? 'سجل العملاء' : 'Customer Database' }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $isRtl ? 'عرض سجلات العملاء، تفاصيل المواعيد، وملاحظات التفضيلات.' : 'Manage salon clients, view WhatsApp chat history, and appointment logs.' }}</p>
        </div>

        <div class="w-full sm:w-72">
            <input type="text" 
                   wire:model.live="search"
                   placeholder="{{ $isRtl ? 'البحث بالاسم أو رقم الهاتف...' : 'Search by customer name or phone...' }}" 
                   class="w-full text-xs bg-white border border-slate-200 rounded-xl px-4 py-2.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
        </div>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-[10px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">{{ $isRtl ? 'العميل' : 'Customer Name' }}</th>
                        <th class="px-6 py-4">{{ $isRtl ? 'رقم الهاتف' : 'Phone Number' }}</th>
                        <th class="px-6 py-4">{{ $isRtl ? 'آخر محادثة' : 'Last Conversation' }}</th>
                        <th class="px-6 py-4">{{ $isRtl ? 'المواعيد' : 'Appointments' }}</th>
                        <th class="px-6 py-4">{{ $isRtl ? 'الحالة' : 'Status' }}</th>
                        <th class="px-6 py-4 text-right">{{ $isRtl ? 'التفاصيل' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($customers as $cust)
                        <tr wire:click="selectCustomer({{ $cust->id }})" class="hover:bg-purple-50/40 cursor-pointer transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $cust->avatar_url }}" alt="" class="w-9 h-9 rounded-full object-cover ring-2 ring-slate-200">
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $cust->name }}</div>
                                        <div class="text-[10px] text-slate-400">Added {{ $cust->created_at->format('M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono font-bold text-slate-800">{{ $cust->phone }}</td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $cust->last_active_at ? $cust->last_active_at->diffForHumans() : 'Recently active' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-mono font-bold text-xs">
                                    {{ $cust->appointments->count() }} booked
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($cust->status === 'VIP')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-purple-100 text-purple-800 border border-purple-200">
                                        ⭐ VIP Customer
                                    </span>
                                @elseif($cust->status === 'Lead')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                        🎯 New Lead
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Active
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-xs font-bold text-purple-600 hover:text-purple-700">View Drawer →</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">No matching customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Detail Panel Drawer -->
    @if($selectedCustomer)
        <div class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div wire:click="closeDrawer" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md bg-white shadow-2xl flex flex-col justify-between">
                    
                    <div>
                        <!-- Drawer Header -->
                        <div class="p-6 bg-slate-900 text-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $selectedCustomer->avatar_url }}" alt="" class="w-12 h-12 rounded-full object-cover ring-2 ring-purple-400">
                                <div>
                                    <h2 class="text-lg font-bold text-white">{{ $selectedCustomer->name }}</h2>
                                    <div class="text-xs font-mono text-purple-300">{{ $selectedCustomer->phone }}</div>
                                </div>
                            </div>
                            <button wire:click="closeDrawer" class="text-slate-400 hover:text-white p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Drawer Body Tabs & Content -->
                        <div class="p-6 space-y-6 overflow-y-auto max-h-[calc(100vh-12rem)]">
                            <!-- Notes -->
                            <div class="bg-amber-50 rounded-xl p-4 border border-amber-200/70 space-y-1">
                                <div class="text-[11px] font-bold uppercase text-amber-800 tracking-wider">Customer Preferences & Notes</div>
                                <p class="text-xs text-amber-900 font-medium">{{ $selectedCustomer->notes ?? 'No special notes recorded.' }}</p>
                            </div>

                            <!-- Appointments History -->
                            <div>
                                <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-3">Appointment History</h3>
                                <div class="space-y-2">
                                    @forelse($selectedCustomer->appointments as $app)
                                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $app->service->name }}</div>
                                                <div class="text-[11px] text-slate-500">With {{ $app->staff->name }} • {{ $app->time_slot }}</div>
                                            </div>
                                            <span class="font-mono font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded">
                                                AED {{ number_format($app->service->price, 0) }}
                                            </span>
                                        </div>
                                    @empty
                                        <div class="text-xs text-slate-400">No past appointments recorded.</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- WhatsApp Conversations History -->
                            <div>
                                <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-3">Recent WhatsApp Messages</h3>
                                <div class="space-y-2">
                                    @foreach($selectedCustomer->conversations as $conv)
                                        @foreach($conv->messages->take(3) as $msg)
                                            <div class="p-2.5 rounded-lg text-xs {{ $msg->sender_type === 'customer' ? 'bg-slate-100 text-slate-800' : 'bg-purple-50 text-purple-900 border border-purple-200' }}">
                                                <div class="text-[9px] font-bold text-slate-400 mb-0.5">{{ $msg->sender_name }}</div>
                                                <div>{{ $msg->content }}</div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-4 border-t border-slate-200 bg-slate-50">
                        <button wire:click="closeDrawer" class="w-full py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs">
                            Close Drawer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
