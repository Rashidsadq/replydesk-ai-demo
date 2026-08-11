<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Conversation;
use App\Models\Customer;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $highlight = null;

    protected $queryString = ['highlight'];

    public function mount()
    {
        $this->highlight = request()->query('highlight');
    }

    public function render()
    {
        $todayAppointments = Appointment::with(['customer', 'service', 'staff'])
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('time_slot')
            ->get();

        $recentConversations = Conversation::with('customer')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // 4 Core Metrics
        $totalAppointmentsCount = Appointment::count();
        $aiBookingsCount = Appointment::where('booked_by_ai', true)->count();
        $aiBookingsCount = $aiBookingsCount > 0 ? $aiBookingsCount + 5 : 9;
        $totalAppointmentsCount = $totalAppointmentsCount > 0 ? $totalAppointmentsCount + 8 : 12;
        $leadsCount = Customer::where('status', 'Lead')->count() + 16; // 17
        $conversationsCount = Conversation::count() + 44; // 48

        // Conversion Rate (17 Leads -> 9 Bookings = 52.9%)
        $conversionRate = 52.9;

        // Sales Demo AI Activity Log
        $aiActivityStream = [
            [
                'type' => 'success',
                'icon' => '✓',
                'title' => 'Booked appointment',
                'details' => 'Daniel Brown • Haircut (AED 80) at 6:00 PM',
                'time' => '2 mins ago',
                'badge' => '+AED 80',
            ],
            [
                'type' => 'success',
                'icon' => '✓',
                'title' => 'Answered pricing question',
                'details' => 'Mohammed Hassan asked about Hair + Beard package',
                'time' => '14 mins ago',
                'badge' => 'Price Provided',
            ],
            [
                'type' => 'success',
                'icon' => '✓',
                'title' => 'Answered opening-hours question',
                'details' => 'Confirmed 10:00 AM - 10:00 PM for Dubai Marina branch',
                'time' => '35 mins ago',
                'badge' => 'Info Sent',
            ],
            [
                'type' => 'warning',
                'icon' => '⚠',
                'title' => 'Transferred conversation to staff',
                'details' => 'Sarah Ahmed requested custom 5-person group package',
                'time' => '1 hour ago',
                'badge' => 'Human Needed',
            ],
        ];

        return view('livewire.dashboard', [
            'todayAppointments' => $todayAppointments,
            'recentConversations' => $recentConversations,
            'totalAppointmentsCount' => $totalAppointmentsCount,
            'aiBookingsCount' => $aiBookingsCount,
            'leadsCount' => $leadsCount,
            'conversationsCount' => $conversationsCount,
            'conversionRate' => $conversionRate,
            'aiActivityStream' => $aiActivityStream,
            'highlight' => $this->highlight,
        ])->layout('components.layouts.app', ['title' => 'Sales Demo Dashboard — ReplyDesk AI']);
    }
}
