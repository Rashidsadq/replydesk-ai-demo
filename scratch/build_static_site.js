import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const rootDir = path.resolve(__dirname, '..');
const distDir = path.join(rootDir, 'dist');

if (!fs.existsSync(distDir)) {
    fs.mkdirSync(distDir, { recursive: true });
}

// Copy public assets to dist
const copyRecursiveSync = (src, dest) => {
    if (fs.existsSync(src)) {
        const stats = fs.statSync(src);
        if (stats.isDirectory()) {
            if (!fs.existsSync(dest)) fs.mkdirSync(dest, { recursive: true });
            fs.readdirSync(src).forEach(childItemName => {
                copyRecursiveSync(path.join(src, childItemName), path.join(dest, childItemName));
            });
        } else {
            fs.copyFileSync(src, dest);
        }
    }
};

copyRecursiveSync(path.join(rootDir, 'public'), distDir);

let cssFile = 'assets/app-BuxVxNQA.css';
let jsFile = 'assets/app-BvRk9kiK.js';
const manifestPath = path.join(rootDir, 'public/build/manifest.json');
if (fs.existsSync(manifestPath)) {
    try {
        const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
        if (manifest['resources/css/app.css']) cssFile = manifest['resources/css/app.css'].file;
        if (manifest['resources/js/app.js']) jsFile = manifest['resources/js/app.js'].file;
    } catch (e) {}
}

const getLayout = (title, activePage, content) => `<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full bg-slate-50 text-slate-900 antialiased" x-data="{ isRtl: false, sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>${title} | ReplyDesk AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/${cssFile}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Instrument Sans', system-ui, sans-serif; }
    </style>
</head>
<body class="h-full font-sans antialiased overflow-x-hidden selection:bg-purple-500 selection:text-white" :dir="isRtl ? 'rtl' : 'ltr'">
    <div class="min-h-screen bg-slate-50 flex flex-col md:flex-row">
        
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-r border-slate-800">
            <div class="h-16 px-4 flex items-center justify-between border-b border-slate-800">
                <a href="/index.html" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-purple-600 flex items-center justify-center text-white font-bold shadow-md shadow-purple-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"></path>
                        </svg>
                    </div>
                    <span class="text-base font-bold text-white tracking-tight">ReplyDesk <span class="text-purple-400">AI</span></span>
                </a>
            </div>

            <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-xs font-medium">
                <a href="/dashboard.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'dashboard' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>📊</span> <span x-text="isRtl ? 'لوحة التحكم' : 'Sales Dashboard'"></span>
                </a>
                <a href="/demo.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'demo' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>💬</span> <span x-text="isRtl ? 'العرض المباشر (واتساب)' : 'Live WhatsApp Demo'"></span>
                </a>
                <a href="/conversations.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'conversations' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>📥</span> <span x-text="isRtl ? 'صندوق المحادثات' : 'Conversations Inbox'"></span>
                </a>
                <a href="/customers.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'customers' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>👥</span> <span x-text="isRtl ? 'دليل العملاء' : 'Customers Directory'"></span>
                </a>
                <a href="/appointments.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'appointments' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>📅</span> <span x-text="isRtl ? 'جدول المواعيد' : 'Appointments Schedule'"></span>
                </a>
                <a href="/services.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'services' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>💈</span> <span x-text="isRtl ? 'قائمة الخدمات' : 'Services & Pricing'"></span>
                </a>
                <a href="/staff.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'staff' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>👨‍💼</span> <span x-text="isRtl ? 'طاقم الحلاقين' : 'Barbers & Staff'"></span>
                </a>
                <a href="/ai-settings.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'ai-settings' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>🤖</span> <span x-text="isRtl ? 'إعدادات الذكاء الاصطناعي' : 'AI Receptionist Rules'"></span>
                </a>
                <a href="/settings.html" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition ${activePage === 'settings' ? 'bg-purple-600 text-white font-bold shadow-md' : 'hover:bg-slate-800 text-slate-300'}">
                    <span>⚙️</span> <span x-text="isRtl ? 'إعدادات الصالون' : 'Business Settings'"></span>
                </a>
            </nav>

            <div class="p-3 border-t border-slate-800">
                <div class="p-3 rounded-xl bg-slate-950/80 border border-slate-800/80 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-white">Elite Barber Dubai</div>
                        <div class="text-[10px] text-purple-400">Dubai Marina • AED</div>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                </div>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar Header -->
            <header class="h-16 bg-white border-b border-slate-200/80 px-4 sm:px-6 flex items-center justify-between shrink-0 shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Demo Store:</span>
                    <span class="text-xs font-extrabold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">Elite Barber Dubai Marina</span>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Language Switcher Toggle -->
                    <button @click="isRtl = !isRtl" class="text-xs font-extrabold px-3 py-1.5 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200 transition">
                        <span x-text="isRtl ? 'English (LTR)' : 'العربية (RTL)'"></span>
                    </button>
                    <a href="/demo.html" class="px-3.5 py-1.5 text-xs font-bold text-white bg-purple-600 hover:bg-purple-500 rounded-xl shadow-md transition">
                        <span x-text="isRtl ? 'العرض المباشر' : 'Live WhatsApp Demo'"></span>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                ${content}
            </main>
        </div>
    </div>
</body>
</html>`;

// Write index.html (Landing Page)
const landingHtml = `<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full bg-slate-950 text-white antialiased" x-data="{ isRtl: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReplyDesk AI — Your AI Receptionist for WhatsApp | Dubai Salons & Barbers</title>
    <link rel="stylesheet" href="/build/${cssFile}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-slate-950 font-sans antialiased" :dir="isRtl ? 'rtl' : 'ltr'">
    <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col font-sans">
        <header class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between z-20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-lg shadow-purple-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">ReplyDesk <span class="text-purple-400">AI</span></span>
            </div>
            <div class="flex items-center gap-4">
                <button @click="isRtl = !isRtl" class="text-xs font-semibold text-slate-300 hover:text-white px-3 py-1.5 rounded-xl border border-slate-800">
                    <span x-text="isRtl ? 'English' : 'العربية (RTL)'"></span>
                </button>
                <a href="/dashboard.html" class="text-sm font-medium text-slate-300 hover:text-white transition hidden sm:inline-block">Dashboard</a>
                <a href="/demo.html" class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 hover:bg-purple-500 rounded-xl shadow-lg transition">Try Live Demo</a>
            </div>
        </header>

        <section class="relative pt-12 pb-20 md:pt-20 md:pb-32 overflow-hidden text-center max-w-7xl mx-auto px-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs text-purple-300 mb-6">
                <span>Built exclusively for Dubai Salons & Barbers</span>
            </div>
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white leading-tight max-w-4xl mx-auto" x-text="isRtl ? 'موظف الاستقبال الذكي الخاص بك على واتساب' : 'Your AI receptionist for WhatsApp.'"></h1>
            <p class="mt-6 text-lg text-slate-400 max-w-2xl mx-auto" x-text="isRtl ? 'الرد الفوري على العملاء، التقاط العملاء المحتملين، وحجز المواعيد تلقائياً 24/7.' : 'Answer customers, capture leads, and book appointments automatically around the clock.'"></p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <a href="/demo.html" class="px-8 py-4 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-2xl shadow-xl transition text-base">Try Live Demo →</a>
                <a href="/dashboard.html" class="px-8 py-4 bg-slate-900 hover:bg-slate-800 text-slate-200 font-semibold rounded-2xl border border-slate-800 text-base">View Business Dashboard</a>
            </div>
        </section>
    </div>
</body>
</html>`;

fs.writeFileSync(path.join(distDir, 'index.html'), landingHtml);

// Write demo.html (Guided Live WhatsApp Simulator)
const demoContent = `
<div x-data="{ 
        isPlaying: false, 
        isTyping: false, 
        currentStep: 1,
        
        async runFullDemo() {
            if (this.isPlaying) return;
            this.isPlaying = true;
            this.currentStep = 1;
            
            this.isTyping = true;
            await new Promise(r => setTimeout(r, 1000));
            this.isTyping = false;
            
            this.currentStep = 2;
            this.isTyping = true;
            await new Promise(r => setTimeout(r, 1200));
            this.isTyping = false;

            this.currentStep = 3;
            this.isPlaying = false;
        }
    }" class="flex flex-col gap-4">

    <!-- Top Guided Demo Header -->
    <div class="bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 text-white rounded-2xl p-4 sm:p-5 border border-purple-800/40 shadow-xl space-y-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-purple-900/60 pb-3">
            <div class="flex items-center gap-3">
                <span class="px-2.5 py-1 rounded-lg text-xs font-extrabold bg-purple-600 text-white tracking-wider uppercase font-mono shadow-md">LIVE DEMO</span>
                <div>
                    <h2 class="text-base font-extrabold text-white" x-text="isRtl ? 'ReplyDesk AI — مسار موظف الاستقبال الآلي' : 'ReplyDesk AI WhatsApp Receptionist Flow'"></h2>
                    <p class="text-xs text-purple-200" x-text="isRtl ? 'شاهد كيف يجيب موظف الذكاء الاصطناعي على استفسارات العملاء ويتحقق من المواعيد ويحجز تلقائياً.' : 'Watch the AI answer customer inquiries, verify slot availability, and book appointments automatically.'"></p>
                </div>
            </div>
            <button @click="runFullDemo()" :disabled="isPlaying" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-extrabold shadow-lg flex items-center gap-2">
                <span x-text="isPlaying ? 'Playing Live Demo...' : '▶ Run Guided Auto Demo'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <div class="p-3 rounded-xl border flex items-center gap-3" :class="currentStep == 1 ? 'bg-purple-900/80 border-purple-500 text-white' : 'bg-slate-900/60 border-slate-800 text-slate-400'">
                <div class="w-7 h-7 rounded-lg bg-purple-600 text-white flex items-center justify-center font-bold">1</div>
                <div><div class="font-bold">Step 1 — Customer asks</div><div class="text-[10px] opacity-80">"How much is a haircut?"</div></div>
            </div>
            <div class="p-3 rounded-xl border flex items-center gap-3" :class="currentStep == 2 ? 'bg-purple-900/80 border-purple-500 text-white' : 'bg-slate-900/60 border-slate-800 text-slate-400'">
                <div class="w-7 h-7 rounded-lg bg-purple-600 text-white flex items-center justify-center font-bold">2</div>
                <div><div class="font-bold">Step 2 — AI responds</div><div class="text-[10px] opacity-80">Pricing & checks slots</div></div>
            </div>
            <div class="p-3 rounded-xl border flex items-center gap-3" :class="currentStep >= 3 ? 'bg-emerald-950/90 border-emerald-500 text-emerald-200' : 'bg-slate-900/60 border-slate-800 text-slate-400'">
                <div class="w-7 h-7 rounded-lg bg-emerald-500 text-white flex items-center justify-center font-bold">✓</div>
                <div><div class="font-bold">Step 3 — Appointment booked</div><div class="text-[10px] opacity-80">Synced with Dashboard</div></div>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-[550px]">
        <div class="h-16 px-4 bg-slate-900 text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-sm">EB</div>
                <div>
                    <div class="text-sm font-bold text-white">Elite Barber Dubai</div>
                    <div class="text-[11px] text-emerald-400">● ReplyDesk AI Receptionist Active</div>
                </div>
            </div>
            <a href="/dashboard.html?highlight=latest" class="text-xs text-purple-200 bg-purple-900/60 px-3 py-1.5 rounded-xl border border-purple-700 font-bold">View Dashboard →</a>
        </div>

        <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-slate-50">
            <!-- Messages -->
            <div class="flex justify-start">
                <div class="bg-white text-slate-800 rounded-2xl p-3.5 max-w-[80%] shadow-sm border border-slate-200 text-xs">
                    <div class="font-bold text-slate-400 text-[10px] mb-1" x-text="isRtl ? 'طارق خليل' : 'Tariq Khalil'"></div>
                    <span x-text="isRtl ? 'مرحباً، كم سعر قص الشعر لديكم؟' : 'Hi 👋 How much is a haircut?'"></span>
                </div>
            </div>

            <div x-show="currentStep >= 2" class="flex justify-end">
                <div class="bg-purple-900 text-white rounded-2xl p-4 max-w-[85%] shadow-lg border border-purple-700 text-xs space-y-2">
                    <div class="text-[10px] text-purple-200 font-bold border-b border-purple-800 pb-1">⚡ ReplyDesk AI Receptionist</div>
                    <p x-text="isRtl ? 'أهلاً بك! سعر قص الشعر 80 درهم واستغرقه 30 دقيقة. لدينا موعد متاح اليوم الساعة 6:00 مساءً مع أحمد حسن. هل تحجز هذا الموعد؟' : 'Hi! Our haircut is AED 80 (30 mins). We have an open slot today at 6:00 PM with Ahmed Hassan. Would you like to book it?'"></p>
                </div>
            </div>

            <div x-show="currentStep >= 3" class="flex justify-end">
                <div class="bg-purple-900 text-white rounded-2xl p-4 max-w-[85%] shadow-lg border border-purple-700 text-xs space-y-3">
                    <div class="text-[10px] text-purple-200 font-bold border-b border-purple-800 pb-1">⚡ ReplyDesk AI Receptionist</div>
                    <p x-text="isRtl ? 'ممتاز! تم حجز موعد قص الشعر الخاص بك بنجاح! ✅' : 'Awesome! Your haircut appointment is confirmed! ✅'"></p>
                    
                    <!-- Confirmation Card -->
                    <div class="bg-slate-900 rounded-2xl p-4 border-2 border-emerald-500 text-left space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                            <span class="text-xs font-extrabold text-emerald-400 uppercase">Appointment Confirmed</span>
                            <span class="text-[10px] font-mono bg-slate-950 px-2 py-0.5 rounded text-emerald-300">#BK-8492</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs bg-slate-950 p-2.5 rounded-xl">
                            <div><span class="text-slate-400 text-[10px] block font-bold">SERVICE</span><span class="font-bold text-white">Haircut</span></div>
                            <div><span class="text-slate-400 text-[10px] block font-bold">STAFF</span><span class="font-bold text-white">Ahmed Hassan</span></div>
                            <div><span class="text-slate-400 text-[10px] block font-bold">TIME</span><span class="font-bold text-emerald-400">Today, 6:00 PM</span></div>
                            <div><span class="text-slate-400 text-[10px] block font-bold">PRICE</span><span class="font-bold text-white">80 AED</span></div>
                        </div>
                        <div class="flex justify-end pt-1">
                            <a href="/dashboard.html?highlight=latest" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs rounded-xl shadow transition">View in Dashboard →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="isTyping" class="flex justify-end">
                <div class="bg-purple-900/80 text-white rounded-2xl px-4 py-2 text-xs flex items-center gap-2">
                    <span>ReplyDesk AI is typing...</span>
                </div>
            </div>
        </div>
    </div>
</div>`;

fs.writeFileSync(path.join(distDir, 'demo.html'), getLayout('Live WhatsApp Demo', 'demo', demoContent));

// Write dashboard.html (Sales Demo Dashboard)
const dashboardContent = `
<div class="space-y-6" x-data="{ highlighted: new URLSearchParams(window.location.search).get('highlight') === 'latest' }">
    
    <!-- Banner if highlighted -->
    <div x-show="highlighted" class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-xl bg-emerald-500 text-slate-950 font-black flex items-center justify-center">✓</span>
            <div>
                <div class="text-xs font-extrabold uppercase tracking-wider text-emerald-900" x-text="isRtl ? 'تم استقبال الحجز الجديد من موظف الواتساب' : 'New Appointment Auto-Booked via WhatsApp AI'"></div>
                <div class="text-xs text-emerald-700" x-text="isRtl ? 'حجز قص شعر #BK-8492 - طارق خليل - 6:00 مساءً مع أحمد حسن' : '#BK-8492 Haircut - Tariq Khalil - 6:00 PM with Ahmed Hassan'"></div>
            </div>
        </div>
        <span class="text-xs font-mono font-bold bg-emerald-200/60 px-3 py-1 rounded-xl text-emerald-900">+80 AED</span>
    </div>

    <!-- 4 Priority Sales KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider" x-text="isRtl ? 'المواعيد المحجوزة بالذكاء الاصطناعي' : 'Bookings generated by AI'"></div>
            <div class="text-3xl font-extrabold text-slate-900">9</div>
            <div class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                <span>+AED 920 revenue generated</span>
            </div>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider" x-text="isRtl ? 'العملاء المحتملون الجدد' : 'New leadsCaptured'"></div>
            <div class="text-3xl font-extrabold text-slate-900">17</div>
            <div class="text-xs text-purple-600 font-semibold">+35% vs last week</div>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider" x-text="isRtl ? 'محادثات الذكاء الاصطناعي' : 'AI Conversations'"></div>
            <div class="text-3xl font-extrabold text-purple-600">48</div>
            <div class="text-xs text-slate-500">24/7 automated coverage</div>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider" x-text="isRtl ? 'مواعيد اليوم' : 'Appointments today'"></div>
            <div class="text-3xl font-extrabold text-slate-900">12</div>
            <div class="text-xs text-emerald-600 font-semibold">9 booked by AI</div>
        </div>
    </div>

    <!-- Sales Conversion Funnel & Activity Stream -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Sales Funnel Visualization -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900" x-text="isRtl ? 'مسار التحويل المباشر للواتساب' : 'WhatsApp Conversion Funnel'"></h3>
                    <p class="text-xs text-slate-500">Conversations → Leads → Bookings</p>
                </div>
                <div class="px-3 py-1.5 rounded-xl bg-purple-50 border border-purple-200 text-purple-700 text-xs font-extrabold">
                    52.9% Conversion Rate
                </div>
            </div>

            <!-- Funnel Stages -->
            <div class="space-y-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-500">STAGE 1 — INBOUND CHATS</div>
                        <div class="text-lg font-extrabold text-slate-900">48 Conversations</div>
                    </div>
                    <span class="text-xs font-bold text-slate-400">100%</span>
                </div>
                <div class="p-4 rounded-xl bg-purple-50/60 border border-purple-200 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-purple-700">STAGE 2 — QUALIFIED LEADS</div>
                        <div class="text-lg font-extrabold text-purple-900">17 Leads</div>
                    </div>
                    <span class="text-xs font-bold text-purple-700">35.4%</span>
                </div>
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-300 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-emerald-700">STAGE 3 — BOOKED APPOINTMENTS</div>
                        <div class="text-lg font-extrabold text-emerald-950">9 Bookings</div>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 font-mono">+920 AED</span>
                </div>
            </div>
        </div>

        <!-- AI Activity Stream -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="text-base font-extrabold text-slate-900" x-text="isRtl ? 'نشاط الذكاء الاصطناعي المباشر' : 'AI Activity Stream'"></h3>
            <div class="space-y-3 text-xs">
                <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 flex items-start gap-3">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <div>
                        <div class="font-bold text-emerald-950">Booked appointment (#BK-8492)</div>
                        <div class="text-[11px] text-emerald-700">Tariq Khalil • Haircut 6:00 PM with Ahmed</div>
                    </div>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                    <span class="text-purple-600 font-bold">✓</span>
                    <div>
                        <div class="font-bold text-slate-800">Answered pricing question</div>
                        <div class="text-[11px] text-slate-500">Haircut 80 AED & Beard Trim 40 AED</div>
                    </div>
                </div>
                <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 flex items-start gap-3">
                    <span class="text-amber-600 font-bold">⚠</span>
                    <div>
                        <div class="font-bold text-amber-950">Transferred conversation to staff</div>
                        <div class="text-[11px] text-amber-700">Sarah Ahmed requested custom hair dye package</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Agenda Schedule Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-6 space-y-4">
        <h3 class="text-base font-extrabold text-slate-900" x-text="isRtl ? 'جدول المواعيد اليوم' : 'Today\'s Salon Schedule'"></h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="p-3">Time</th>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Service</th>
                        <th class="p-3">Barber</th>
                        <th class="p-3">Source</th>
                        <th class="p-3">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr :class="highlighted ? 'bg-emerald-50/90 ring-2 ring-emerald-500/60 font-bold' : ''" class="transition">
                        <td class="p-3 text-emerald-700 font-mono">6:00 PM</td>
                        <td class="p-3 font-bold text-slate-800">Tariq Khalil (+971 50 882 1928)</td>
                        <td class="p-3">Haircut (30 mins)</td>
                        <td class="p-3">Ahmed Hassan</td>
                        <td class="p-3"><span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-md font-bold">🤖 ReplyDesk AI</span></td>
                        <td class="p-3 font-mono font-bold text-slate-900">80 AED</td>
                    </tr>
                    <tr>
                        <td class="p-3 text-slate-500 font-mono">6:30 PM</td>
                        <td class="p-3 font-bold text-slate-800">Youssef Mansoor</td>
                        <td class="p-3">Beard Trim</td>
                        <td class="p-3">Omar Khalid</td>
                        <td class="p-3"><span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-md font-bold">🤖 ReplyDesk AI</span></td>
                        <td class="p-3 font-mono font-bold text-slate-900">40 AED</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>`;

fs.writeFileSync(path.join(distDir, 'dashboard.html'), getLayout('Sales Dashboard', 'dashboard', dashboardContent));

// Write conversations.html
const conversationsContent = `
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4" x-data="{ humanTakenOver: false }">
    <div class="flex items-center justify-between border-b pb-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Conversations Inbox</h2>
            <p class="text-xs text-slate-500">Live WhatsApp Chat Streams</p>
        </div>
        <button @click="humanTakenOver = !humanTakenOver" class="px-4 py-2 rounded-xl text-xs font-bold transition" :class="humanTakenOver ? 'bg-amber-500 text-slate-950' : 'bg-purple-600 text-white'">
            <span x-text="humanTakenOver ? '⚠️ Return to AI Receptionist' : '👨‍💼 Take Over Conversation'"></span>
        </button>
    </div>

    <div x-show="humanTakenOver" class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
        ⚠️ AI receptionist paused. You are now manually handling this conversation stream.
    </div>

    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3 text-xs">
        <div class="font-bold text-slate-700">Sarah Ahmed (+971 52 119 4029)</div>
        <div class="p-3 bg-white rounded-xl border border-slate-200">Hi, do you offer bridal or group hair dye packages?</div>
        <div class="p-3 bg-purple-900 text-white rounded-xl">Hi Sarah 👋 I am transferring your request to our salon manager immediately!</div>
    </div>
</div>`;

fs.writeFileSync(path.join(distDir, 'conversations.html'), getLayout('Conversations Inbox', 'conversations', conversationsContent));

// Write customers.html
const customersContent = `
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
    <h2 class="text-lg font-bold text-slate-900">Customers Directory</h2>
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-500 font-bold border-b">
            <tr><th class="p-3">Customer</th><th class="p-3">Phone</th><th class="p-3">Status</th><th class="p-3">Total Spend</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <tr><td class="p-3 font-bold">Tariq Khalil</td><td class="p-3 font-mono">+971 50 882 1928</td><td class="p-3"><span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-md font-bold">Active Client</span></td><td class="p-3 font-mono font-bold">240 AED</td></tr>
            <tr><td class="p-3 font-bold">Sarah Ahmed</td><td class="p-3 font-mono">+971 52 119 4029</td><td class="p-3"><span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-md font-bold">Lead</span></td><td class="p-3 font-mono font-bold">0 AED</td></tr>
        </tbody>
    </table>
</div>`;

fs.writeFileSync(path.join(distDir, 'customers.html'), getLayout('Customers Directory', 'customers', customersContent));

// Write appointments.html, services.html, staff.html, ai-settings.html, settings.html
const simplePage = (title, active) => `
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
    <h2 class="text-lg font-bold text-slate-900">${title}</h2>
    <p class="text-xs text-slate-500">Elite Barber Dubai Marina • AED</p>
    <div class="p-8 text-center text-slate-400 text-xs bg-slate-50 rounded-xl border border-slate-200 font-medium">
        ${title} Management Panel Ready for Presentation.
    </div>
</div>`;

fs.writeFileSync(path.join(distDir, 'appointments.html'), getLayout('Appointments Agenda', 'appointments', simplePage('Appointments Agenda', 'appointments')));
fs.writeFileSync(path.join(distDir, 'services.html'), getLayout('Services & Pricing', 'services', simplePage('Services & Pricing (AED)', 'services')));
fs.writeFileSync(path.join(distDir, 'staff.html'), getLayout('Barber Staff Roster', 'staff', simplePage('Barber Staff Roster', 'staff')));
fs.writeFileSync(path.join(distDir, 'ai-settings.html'), getLayout('AI Receptionist Rules', 'ai-settings', simplePage('AI Receptionist Rules', 'ai-settings')));
fs.writeFileSync(path.join(distDir, 'settings.html'), getLayout('Business Settings', 'settings', simplePage('Business Settings', 'settings')));

// Create vercel.json for static hosting
const vercelConfig = {
    version: 2,
    outputDirectory: "dist"
};
fs.writeFileSync(path.join(rootDir, 'vercel.json'), JSON.stringify(vercelConfig, null, 2));

console.log("Static HTML Frontend Bundle successfully compiled into dist/");
