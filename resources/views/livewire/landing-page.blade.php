@php
    $isRtl = session('locale') === 'ar';
@endphp

<div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col font-sans">
    
    <!-- Navigation Header -->
    <header class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between z-20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-lg shadow-purple-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"></path>
                </svg>
            </div>
            <div>
                <span class="text-xl font-bold tracking-tight text-white">ReplyDesk <span class="text-purple-400">AI</span></span>
                <span class="hidden sm:inline-block ml-2 text-xs bg-purple-500/20 text-purple-300 px-2 py-0.5 rounded-full border border-purple-500/30">Dubai Edition</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('toggle-language') }}" class="text-xs font-semibold text-slate-300 hover:text-white px-3 py-1.5 rounded-xl border border-slate-800 hover:border-slate-700 transition">
                {{ $isRtl ? 'English' : 'العربية (RTL)' }}
            </a>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition hidden sm:inline-block">
                {{ $isRtl ? 'لوحة التحكم' : 'Dashboard' }}
            </a>
            <a href="{{ route('demo') }}" class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 hover:bg-purple-500 rounded-xl shadow-lg shadow-purple-600/30 transition transform hover:-translate-y-0.5">
                {{ $isRtl ? 'جرب العرض المباشر' : 'Try Live Demo' }}
            </a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 md:pt-20 md:pb-32 overflow-hidden">
        <!-- Glow accents -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-purple-600/20 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Market Pill -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs text-purple-300 mb-6 shadow-xl">
                <span class="flex h-2 w-2 relative">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                </span>
                <span>{{ $isRtl ? 'مصمم خصيصاً للصالونات ومحلات الحلاقة في دبي' : 'Built exclusively for Dubai Salons & Barbers' }}</span>
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-white leading-tight max-w-4xl mx-auto">
                {{ $isRtl ? 'موظف الاستقبال الذكي الخاص بك على واتساب' : 'Your AI receptionist for WhatsApp.' }}
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto font-normal leading-relaxed">
                {{ $isRtl ? 'الرد الفوري على العملاء، التقاط العملاء المحتملين، وحجز المواعيد تلقائياً 24/7 باللغتين الإنجليزية والعربية.' : 'Answer customers, capture leads, and book appointments automatically around the clock.' }}
            </p>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('demo') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold rounded-2xl shadow-xl shadow-purple-900/50 flex items-center justify-center gap-3 transition transform hover:-translate-y-0.5 text-base">
                    <span>{{ $isRtl ? 'جرب العرض الفوري التفاعلي' : 'Try Live Demo' }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="#how-it-works" class="w-full sm:w-auto px-8 py-4 bg-slate-900 hover:bg-slate-800 text-slate-200 font-semibold rounded-2xl border border-slate-800 text-base transition">
                    {{ $isRtl ? 'كيف يعمل النظام' : 'See How It Works' }}
                </a>
            </div>

            <!-- Product Showcase Preview Card -->
            <div class="mt-14 max-w-5xl mx-auto rounded-3xl p-3 bg-slate-900/80 border border-slate-800 shadow-2xl backdrop-blur-xl">
                <div class="bg-slate-950 rounded-2xl p-4 sm:p-6 border border-slate-800/80 grid grid-cols-1 lg:grid-cols-12 gap-6 text-left">
                    
                    <!-- Left: Floating WhatsApp Preview -->
                    <div class="lg:col-span-5 bg-slate-900/90 rounded-xl p-4 border border-slate-800 space-y-3">
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-800">
                            <div class="w-9 h-9 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-sm">
                                EB
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">Elite Barber Dubai</div>
                                <div class="text-[11px] text-emerald-400 font-medium flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> ReplyDesk AI Receptionist
                                </div>
                            </div>
                        </div>

                        <!-- Chat bubble simulation -->
                        <div class="space-y-2.5 text-xs">
                            <div class="bg-slate-800 p-2.5 rounded-lg rounded-tl-none max-w-[85%] text-slate-200">
                                Hi, how much is a haircut?
                            </div>
                            <div class="bg-purple-900/60 border border-purple-500/30 p-2.5 rounded-lg rounded-tr-none max-w-[85%] ml-auto text-purple-100">
                                Hi 👋 Our haircut is AED 80 and takes around 30 minutes. Would you like to book an appointment?
                            </div>
                            <div class="bg-slate-800 p-2.5 rounded-lg rounded-tl-none max-w-[85%] text-slate-200">
                                Yes, tomorrow at 6 PM.
                            </div>
                            <div class="bg-purple-900/60 border border-purple-500/30 p-2.5 rounded-lg rounded-tr-none max-w-[85%] ml-auto text-purple-100 font-medium">
                                Perfect! Your haircut is booked for tomorrow at 6:00 PM with Ahmed. ✅
                            </div>
                        </div>
                    </div>

                    <!-- Right: Dashboard Preview -->
                    <div class="lg:col-span-7 bg-slate-900/50 rounded-xl p-4 border border-slate-800 flex flex-col justify-between">
                        <div>
                            <div class="text-xs font-semibold text-purple-400 uppercase tracking-wider mb-1">Live Salon Overview</div>
                            <div class="text-lg font-bold text-white">Elite Barber Dubai • Marina</div>
                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <div class="p-3 bg-slate-950 rounded-xl border border-slate-800">
                                    <div class="text-slate-400 text-xs">Today's Bookings</div>
                                    <div class="text-xl font-bold text-white mt-1">12</div>
                                </div>
                                <div class="p-3 bg-slate-950 rounded-xl border border-slate-800">
                                    <div class="text-slate-400 text-xs">AI Conversations</div>
                                    <div class="text-xl font-bold text-purple-400 mt-1">48</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-emerald-950/40 border border-emerald-800/40 rounded-xl flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span class="text-xs font-medium text-emerald-200">9 appointments auto-booked by AI today</span>
                            </div>
                            <span class="text-xs font-mono font-bold text-emerald-400">+AED 920</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-slate-900/60 border-y border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    {{ $isRtl ? 'كيف يساعد صالونك في دبي؟' : 'How ReplyDesk AI Elevates Your Dubai Salon' }}
                </h2>
                <p class="mt-4 text-slate-400 text-base">
                    {{ $isRtl ? 'حل متكامل لإدارة استقبال الواتساب وتنمية الحجوزات دون الحاجة لتعيين موظفين إضافيين.' : 'Turn WhatsApp into your highest converting booking channel with 3 simple steps.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="p-6 bg-slate-950 rounded-2xl border border-slate-800 space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-600/20 text-purple-400 border border-purple-500/30 flex items-center justify-center font-bold text-lg">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-white">Instant Answers 24/7</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        ReplyDesk AI instantly responds to price questions, location queries, and working hours in English & Arabic.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-6 bg-slate-950 rounded-2xl border border-slate-800 space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-bold text-lg">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-white">Automated Calendar Booking</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Checks barber availability, suggests open time slots, and reserves appointments directly into your schedule.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-6 bg-slate-950 rounded-2xl border border-slate-800 space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-bold text-lg">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-white">Seamless Human Takeover</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        When a customer requests custom packages or manager assistance, your team can take over with a single click.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Grid -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 text-xs font-semibold text-purple-400 uppercase tracking-wider">
                        Bilingual AI Capabilities
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                        Fluent in English & Arabic for Dubai's Diverse Clientele
                    </h2>
                    <p class="text-slate-400 text-base leading-relaxed">
                        Dubai is home to over 200 nationalities. ReplyDesk AI seamlessly switches between English and Arabic, understanding local Dubai salon terminology, AED pricing, and customary greetings.
                    </p>

                    <div class="space-y-3 pt-2">
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">✓</div>
                            <span class="text-slate-200 text-sm font-medium">Automatic language detection (English & Arabic RTL support)</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">✓</div>
                            <span class="text-slate-200 text-sm font-medium">Real-time sync with barber working hours and breaks</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">✓</div>
                            <span class="text-slate-200 text-sm font-medium">Full business dashboard for staff management and metrics</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <span class="text-xs font-bold text-slate-400">Arabic Conversation Demo</span>
                        <span class="text-xs text-purple-400 font-mono">dir="rtl"</span>
                    </div>

                    <div class="space-y-3 dir-rtl text-right font-sans">
                        <div class="bg-slate-800 p-3 rounded-xl rounded-tr-none text-xs text-slate-100 max-w-[80%] mr-auto">
                            كم سعر الحلاقة؟
                        </div>
                        <div class="bg-purple-900/60 border border-purple-500/30 p-3 rounded-xl rounded-tl-none text-xs text-purple-100 max-w-[85%]">
                            سعر الحلاقة 80 درهم وتستغرق حوالي 30 دقيقة. هل ترغب في حجز موعد؟
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Banner -->
    <section class="py-16 bg-gradient-to-br from-purple-950 via-slate-900 to-slate-950 border-t border-purple-900/30">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-6">
            <h2 class="text-3xl sm:text-5xl font-extrabold text-white">
                Ready to automate your salon bookings?
            </h2>
            <p class="text-slate-300 text-base max-w-xl mx-auto">
                Experience the live interactive demo to see how ReplyDesk AI handles WhatsApp messages and books appointments in real time.
            </p>
            <div>
                <a href="{{ route('demo') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-2xl shadow-xl shadow-purple-600/40 text-base transition transform hover:scale-105">
                    <span>Launch Live Interactive Demo</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-slate-950 border-t border-slate-900 text-center text-xs text-slate-400">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>© 2026 ReplyDesk AI. Designed for Dubai Salons & Barbers.</div>
            <div class="flex items-center gap-4">
                <a href="{{ route('demo') }}" class="hover:text-white">Live Demo</a>
                <a href="{{ route('dashboard') }}" class="hover:text-white">Dashboard</a>
                <a href="{{ route('settings') }}" class="hover:text-white">Settings</a>
            </div>
        </div>
    </footer>
</div>
