@php
    $isRtl = session('locale') === 'ar';
@endphp

<!-- Mobile Backdrop -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 md:hidden">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }}'"
       class="fixed md:static inset-y-0 {{ $isRtl ? 'right-0' : 'left-0' }} z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out md:translate-x-0 border-r border-slate-800 shrink-0 shadow-2xl md:shadow-none">
    
    <div>
        <!-- Brand Header -->
        <div class="h-16 px-6 flex items-center justify-between border-b border-slate-800 bg-slate-950/40">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-lg shadow-purple-900/40 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-white tracking-tight flex items-center gap-1.5 text-base">
                        ReplyDesk <span class="text-xs bg-purple-500/20 text-purple-300 px-1.5 py-0.5 rounded font-mono font-medium border border-purple-500/30">AI</span>
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">WhatsApp Receptionist</div>
                </div>
            </a>

            <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="px-3 py-4 space-y-1">
            <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                {{ $isRtl ? 'العرض التوضيحي المباشر' : 'Live Interactive Demo' }}
            </div>
            
            <a href="{{ route('demo') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('demo') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-lg shadow-purple-900/30' : 'text-purple-300 hover:bg-slate-800/80 hover:text-white' }}">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $isRtl ? 'محادثة واتساب التجريبية' : 'WhatsApp Live Chat' }}</span>
                <span class="ml-auto relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
            </a>

            <div class="px-3 pt-5 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                {{ $isRtl ? 'لوحة تحكم الصالون' : 'Salon Management' }}
            </div>

            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span>{{ $isRtl ? 'لوحة التحكم' : 'Dashboard' }}</span>
            </a>

            <a href="{{ route('conversations') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('conversations') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                </svg>
                <span>{{ $isRtl ? 'المحادثات' : 'Conversations' }}</span>
                <span class="ml-auto bg-purple-500/20 text-purple-300 text-xs px-2 py-0.5 rounded-full border border-purple-500/30 font-semibold">4</span>
            </a>

            <a href="{{ route('customers') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('customers') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>{{ $isRtl ? 'العملاء' : 'Customers' }}</span>
            </a>

            <a href="{{ route('appointments') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('appointments') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 3V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $isRtl ? 'المواعيد' : 'Appointments' }}</span>
            </a>

            <a href="{{ route('services') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('services') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14 4l5.121 5.121"></path>
                </svg>
                <span>{{ $isRtl ? 'الخدمات والأسعار' : 'Services & Pricing' }}</span>
            </a>

            <a href="{{ route('staff') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('staff') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>{{ $isRtl ? 'طاقم الحلاقين' : 'Barbers & Staff' }}</span>
            </a>

            <div class="px-3 pt-5 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                {{ $isRtl ? 'إعدادات الذكاء الاصطناعي' : 'AI & Business Setup' }}
            </div>

            <a href="{{ route('ai-settings') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('ai-settings') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>{{ $isRtl ? 'إعدادات الذكاء الاصطناعي' : 'AI Rules & Receptionist' }}</span>
            </a>

            <a href="{{ route('settings') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ request()->routeIs('settings') ? 'bg-purple-600 text-white shadow-md shadow-purple-900/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>{{ $isRtl ? 'إعدادات المتجر' : 'Business Settings' }}</span>
            </a>
        </nav>
    </div>

    <!-- Active Demo Business Footer Badge -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/60">
        <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/60">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-xs font-semibold text-white">Elite Barber Dubai</span>
                <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-medium">AED</span>
            </div>
            <div class="text-[11px] text-slate-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-purple-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="truncate">Dubai Marina, Dubai</span>
            </div>
        </div>
    </div>
</aside>
