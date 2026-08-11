<?php

use App\Livewire\AiSettings;
use App\Livewire\AppointmentsPage;
use App\Livewire\BusinessSettings;
use App\Livewire\Conversations;
use App\Livewire\Customers;
use App\Livewire\Dashboard;
use App\Livewire\DemoChat;
use App\Livewire\LandingPage;
use App\Livewire\ServicesPage;
use App\Livewire\StaffPage;
use Illuminate\Support\Facades\Route;

// 1. Marketing Landing Page
Route::get('/', LandingPage::class)->name('home');

// 2. Demo WhatsApp Chat Simulator
Route::get('/demo/{conversationId?}', DemoChat::class)->name('demo');

// 3. SaaS Dashboard
Route::get('/dashboard', Dashboard::class)->name('dashboard');

// 4. Conversations Inbox
Route::get('/conversations/{id?}', Conversations::class)->name('conversations');

// 5. Customers Directory
Route::get('/customers', Customers::class)->name('customers');

// 6. Appointments Agenda / Calendar
Route::get('/appointments', AppointmentsPage::class)->name('appointments');

// 7. Services & Pricing
Route::get('/services', ServicesPage::class)->name('services');

// 8. Barbers & Staff
Route::get('/staff', StaffPage::class)->name('staff');

// 9. AI Receptionist Settings
Route::get('/ai-settings', AiSettings::class)->name('ai-settings');

// 10. Business Settings & Language Toggle
Route::get('/settings', BusinessSettings::class)->name('settings');

// Quick Language Switcher Route
Route::get('/toggle-language', function () {
    $current = session('locale', 'en');
    $next = $current === 'ar' ? 'en' : 'ar';
    session(['locale' => $next]);
    return redirect()->back();
})->name('toggle-language');
