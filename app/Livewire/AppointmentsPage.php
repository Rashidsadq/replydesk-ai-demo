<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Livewire\Component;

class AppointmentsPage extends Component
{
    public $activeTab = 'all'; // all, confirmed, pending, cancelled
    public $showRescheduleModal = false;
    public $rescheduleAppointmentId = null;
    public $newTimeSlot = '4:00 PM';

    public function filterTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updateStatus($appointmentId, $status)
    {
        $app = Appointment::findOrFail($appointmentId);
        $app->update(['status' => $status]);
    }

    public function openReschedule($appointmentId)
    {
        $this->rescheduleAppointmentId = $appointmentId;
        $this->showRescheduleModal = true;
    }

    public function saveReschedule()
    {
        if ($this->rescheduleAppointmentId) {
            $app = Appointment::findOrFail($this->rescheduleAppointmentId);
            $app->update(['time_slot' => $this->newTimeSlot]);
        }
        $this->showRescheduleModal = false;
        $this->rescheduleAppointmentId = null;
    }

    public function render()
    {
        $query = Appointment::with(['customer', 'service', 'staff'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('time_slot', 'asc');

        if ($this->activeTab !== 'all') {
            $query->where('status', $this->activeTab);
        }

        $appointments = $query->get();

        return view('livewire.appointments-page', [
            'appointments' => $appointments,
        ])->layout('components.layouts.app', ['title' => 'Appointments Calendar — ReplyDesk AI']);
    }
}
