@php
    $isRtl = session('locale') === 'ar';
@endphp

<header class="h-16 bg-white border-b border-slate-200/80 px-4 sm:px-6 flex items-center justify-between z-10 shrink-0">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="md:hidden p-2 text-slate-500 hover:text-slate-700 rounded-lg hover:bg-slate-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="relative hidden sm:block w-64 md:w-80">
            <div class="absolute inset-y-0 {{ $isRtl ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" 
                   placeholder="{{ $isRtl ? 'البحث في المواعيد والعملاء...' : 'Search appointments, customers...' }}" 
                   class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl {{ $isRtl ? 'pr-9 pl-3' : 'pl-9 pr-3' }} py-2 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition-all text-slate-700">
        </div>
    </div>

    <div class="flex items-center gap-3">
        <!-- Language Switcher Form / Toggle -->
        <a href="{{ route('toggle-language') }}" 
           title="Switch Language / RTL"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 text-xs font-semibold text-slate-700 hover:border-purple-300 hover:bg-purple-50 hover:text-purple-700 transition-all">
            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
            </svg>
            <span>{{ $isRtl ? 'English' : 'العربية (RTL)' }}</span>
        </a>

        <!-- Live Demo Quick Action Link -->
        <a href="{{ route('demo') }}" class="hidden lg:inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-purple-50 text-purple-700 border border-purple-200/60 hover:bg-purple-100 text-xs font-semibold transition-all">
            <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
            <span>{{ $isRtl ? 'عرض محادثة الواتساب' : 'Live Chat Demo' }}</span>
        </a>

        <!-- User Profile Pill -->
        <div class="flex items-center gap-2.5 pl-2 border-l border-slate-200">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" 
                 alt="Ahmed Hassan" 
                 class="w-8 h-8 rounded-full object-cover ring-2 ring-purple-500/30">
            <div class="hidden sm:block text-left">
                <div class="text-xs font-bold text-slate-800 leading-tight">Ahmed Hassan</div>
                <div class="text-[10px] font-medium text-slate-500">Salon Manager</div>
            </div>
        </div>
    </div>
</header>
