<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\BusinessSetting;
use App\Models\Conversation;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Business Settings
        BusinessSetting::truncate();
        BusinessSetting::create([
            'name' => 'Elite Barber Dubai',
            'tagline' => 'Your AI receptionist for WhatsApp.',
            'location' => 'Dubai Marina, Dubai',
            'phone' => '+971 4 555 0188',
            'opening_hours' => '10:00 AM - 10:00 PM',
            'currency' => 'AED',
            'language' => 'en',
            'ai_enabled' => true,
            'capabilities' => [
                'service_questions' => true,
                'pricing_questions' => true,
                'check_availability' => true,
                'book_appointments' => true,
                'answer_faqs' => true,
                'transfer_to_staff' => true,
            ],
            'rules' => [
                'Only provide information configured by the business.',
                'Never invent prices or appointment availability.',
                'If unsure, transfer the customer to staff.',
            ],
        ]);

        // Services
        Service::truncate();
        $haircut = Service::create([
            'name' => 'Haircut',
            'name_ar' => 'قص شعر',
            'price' => 80.00,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        $beardTrim = Service::create([
            'name' => 'Beard Trim',
            'name_ar' => 'تشذيب اللحية',
            'price' => 40.00,
            'duration_minutes' => 20,
            'is_active' => true,
        ]);

        $hairAndBeard = Service::create([
            'name' => 'Hair + Beard',
            'name_ar' => 'شعر + لحية',
            'price' => 110.00,
            'duration_minutes' => 50,
            'is_active' => true,
        ]);

        $kidsHaircut = Service::create([
            'name' => 'Kids Haircut',
            'name_ar' => 'قص شعر للأطفال',
            'price' => 60.00,
            'duration_minutes' => 25,
            'is_active' => true,
        ]);

        // Staff
        Staff::truncate();
        $ahmed = Staff::create([
            'name' => 'Ahmed Hassan',
            'role' => 'Senior Stylist & Barber',
            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200',
            'services' => ['Haircut', 'Beard Trim', 'Hair + Beard'],
            'working_hours' => '10:00 AM - 6:00 PM',
            'status' => 'available',
        ]);

        $omar = Staff::create([
            'name' => 'Omar Khalid',
            'role' => 'Beard Specialist',
            'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=200',
            'services' => ['Beard Trim', 'Hair + Beard', 'Kids Haircut'],
            'working_hours' => '12:00 PM - 8:00 PM',
            'status' => 'available',
        ]);

        $mohammedStaff = Staff::create([
            'name' => 'Mohammed Ali',
            'role' => 'Master Barber',
            'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=200',
            'services' => ['Haircut', 'Beard Trim', 'Hair + Beard', 'Kids Haircut'],
            'working_hours' => '2:00 PM - 10:00 PM',
            'status' => 'busy',
        ]);

        // Customers
        Customer::truncate();
        $mohammedCust = Customer::create([
            'name' => 'Mohammed Hassan',
            'phone' => '+971 50 123 4567',
            'avatar_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=200',
            'status' => 'VIP',
            'notes' => 'Prefers Ahmed. Likes extra beard oil.',
            'last_active_at' => Carbon::now()->subMinutes(12),
        ]);

        $johnCust = Customer::create([
            'name' => 'John Smith',
            'phone' => '+971 55 234 5678',
            'avatar_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=200',
            'status' => 'Active',
            'notes' => 'Regular weekend customer.',
            'last_active_at' => Carbon::now()->subHours(2),
        ]);

        $danielCust = Customer::create([
            'name' => 'Daniel Brown',
            'phone' => '+971 52 345 6789',
            'avatar_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=200',
            'status' => 'Active',
            'notes' => 'Booked via AI receptionist.',
            'last_active_at' => Carbon::now()->subMinutes(30),
        ]);

        $sarahCust = Customer::create([
            'name' => 'Sarah Ahmed',
            'phone' => '+971 54 456 7890',
            'avatar_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=200',
            'status' => 'Lead',
            'notes' => 'Requested custom hair treatment package.',
            'last_active_at' => Carbon::now()->subHours(5),
        ]);

        $aliCust = Customer::create([
            'name' => 'Ali Mansoor',
            'phone' => '+971 50 987 6543',
            'avatar_url' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&q=80&w=200',
            'status' => 'Active',
            'notes' => 'Beard trim enthusiast.',
            'last_active_at' => Carbon::now()->subHours(1),
        ]);

        // Appointments
        Appointment::truncate();
        $today = Carbon::today();

        Appointment::create([
            'customer_id' => $mohammedCust->id,
            'service_id' => $haircut->id,
            'staff_id' => $ahmed->id,
            'appointment_date' => $today,
            'time_slot' => '10:00 AM',
            'status' => 'confirmed',
            'booked_by_ai' => true,
        ]);

        Appointment::create([
            'customer_id' => $aliCust->id,
            'service_id' => $beardTrim->id,
            'staff_id' => $omar->id,
            'appointment_date' => $today,
            'time_slot' => '12:30 PM',
            'status' => 'confirmed',
            'booked_by_ai' => true,
        ]);

        Appointment::create([
            'customer_id' => $johnCust->id,
            'service_id' => $hairAndBeard->id,
            'staff_id' => $mohammedStaff->id,
            'appointment_date' => $today,
            'time_slot' => '2:00 PM',
            'status' => 'confirmed',
            'booked_by_ai' => false,
        ]);

        Appointment::create([
            'customer_id' => $danielCust->id,
            'service_id' => $haircut->id,
            'staff_id' => $ahmed->id,
            'appointment_date' => $today,
            'time_slot' => '6:00 PM',
            'status' => 'confirmed',
            'booked_by_ai' => true,
        ]);

        // Additional appointments for demonstration
        Appointment::create([
            'customer_id' => $sarahCust->id,
            'service_id' => $kidsHaircut->id,
            'staff_id' => $omar->id,
            'appointment_date' => $today->copy()->addDay(),
            'time_slot' => '11:00 AM',
            'status' => 'pending',
            'booked_by_ai' => true,
        ]);

        // Conversations & Messages
        Conversation::truncate();
        Message::truncate();

        // Conv 1: Daniel Brown (Demo Chat default flow)
        $convDaniel = Conversation::create([
            'customer_id' => $danielCust->id,
            'status' => 'ai_active',
            'last_message' => 'Perfect! Your haircut is booked for tomorrow at 6:00 PM with Ahmed. ✅',
            'last_message_at' => Carbon::now()->subMinutes(15),
            'unread_count' => 0,
            'summary' => 'Daniel — Asking about prices — AI handled',
        ]);

        Message::create([
            'conversation_id' => $convDaniel->id,
            'sender_type' => 'customer',
            'sender_name' => 'Daniel Brown',
            'content' => 'Hi, how much is a haircut?',
            'created_at' => Carbon::now()->subMinutes(20),
        ]);

        Message::create([
            'conversation_id' => $convDaniel->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Hi 👋 Our haircut is AED 80 and takes around 30 minutes. Would you like to book an appointment?',
            'created_at' => Carbon::now()->subMinutes(19),
        ]);

        Message::create([
            'conversation_id' => $convDaniel->id,
            'sender_type' => 'customer',
            'sender_name' => 'Daniel Brown',
            'content' => 'Yes, tomorrow at 6 PM.',
            'created_at' => Carbon::now()->subMinutes(18),
        ]);

        Message::create([
            'conversation_id' => $convDaniel->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'I have 6:00 PM and 6:30 PM available. Which one would you prefer?',
            'created_at' => Carbon::now()->subMinutes(17),
        ]);

        Message::create([
            'conversation_id' => $convDaniel->id,
            'sender_type' => 'customer',
            'sender_name' => 'Daniel Brown',
            'content' => '6:00 PM',
            'created_at' => Carbon::now()->subMinutes(16),
        ]);

        Message::create([
            'conversation_id' => $convDaniel->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Perfect! Your haircut is booked for tomorrow at 6:00 PM with Ahmed. ✅',
            'is_booking_confirmation' => true,
            'booking_details' => [
                'service' => 'Haircut',
                'price' => '80 AED',
                'duration' => '30 mins',
                'time' => 'Tomorrow, 6:00 PM',
                'staff' => 'Ahmed Hassan',
                'status' => 'Confirmed',
            ],
            'created_at' => Carbon::now()->subMinutes(15),
        ]);

        // Conv 2: Mohammed Hassan
        $convMohammed = Conversation::create([
            'customer_id' => $mohammedCust->id,
            'status' => 'ai_active',
            'last_message' => 'Great! Your Hair + Beard appointment is locked in for 10:00 AM today.',
            'last_message_at' => Carbon::now()->subMinutes(45),
            'unread_count' => 0,
            'summary' => 'Mohammed — Wants haircut tomorrow — AI handled',
        ]);

        Message::create([
            'conversation_id' => $convMohammed->id,
            'sender_type' => 'customer',
            'sender_name' => 'Mohammed Hassan',
            'content' => 'Salam! Do you have any slot for Hair + Beard today morning?',
            'created_at' => Carbon::now()->subHour(),
        ]);

        Message::create([
            'conversation_id' => $convMohammed->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Wa Alaikum Assalam Mohammed! 🌿 Yes, we have 10:00 AM with Ahmed available.',
            'created_at' => Carbon::now()->subMinutes(50),
        ]);

        Message::create([
            'conversation_id' => $convMohammed->id,
            'sender_type' => 'customer',
            'sender_name' => 'Mohammed Hassan',
            'content' => 'Book 10:00 AM please.',
            'created_at' => Carbon::now()->subMinutes(48),
        ]);

        Message::create([
            'conversation_id' => $convMohammed->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Great! Your Hair + Beard appointment is locked in for 10:00 AM today.',
            'is_booking_confirmation' => true,
            'booking_details' => [
                'service' => 'Hair + Beard',
                'price' => '110 AED',
                'duration' => '50 mins',
                'time' => 'Today, 10:00 AM',
                'staff' => 'Ahmed Hassan',
                'status' => 'Confirmed',
            ],
            'created_at' => Carbon::now()->subMinutes(45),
        ]);

        // Conv 3: Sarah Ahmed (Human Needed)
        $convSarah = Conversation::create([
            'customer_id' => $sarahCust->id,
            'status' => 'human_handling',
            'last_message' => 'I would like to inquire about wedding group packages for 5 people this Friday.',
            'last_message_at' => Carbon::now()->subHours(2),
            'unread_count' => 1,
            'summary' => 'Sarah — Wants special request — Human needed',
        ]);

        Message::create([
            'conversation_id' => $convSarah->id,
            'sender_type' => 'customer',
            'sender_name' => 'Sarah Ahmed',
            'content' => 'I would like to inquire about wedding group packages for 5 people this Friday.',
            'created_at' => Carbon::now()->subHours(2),
        ]);

        Message::create([
            'conversation_id' => $convSarah->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Thank you for reaching out! Custom group bookings require manager confirmation. I am transferring your request to our team right away.',
            'created_at' => Carbon::now()->subHours(2)->addMinutes(1),
        ]);

        // Conv 4: John Smith
        $convJohn = Conversation::create([
            'customer_id' => $johnCust->id,
            'status' => 'ai_active',
            'last_message' => 'See you at 2:00 PM today, John!',
            'last_message_at' => Carbon::now()->subHours(3),
            'unread_count' => 0,
            'summary' => 'John — Booked Hair + Beard — AI handled',
        ]);

        Message::create([
            'conversation_id' => $convJohn->id,
            'sender_type' => 'customer',
            'sender_name' => 'John Smith',
            'content' => 'Are you located near Marina Mall?',
            'created_at' => Carbon::now()->subHours(3)->subMinutes(10),
        ]);

        Message::create([
            'conversation_id' => $convJohn->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => 'Yes! We are located at Dubai Marina Promenade, right next to Marina Mall. Free valet parking available! 🚗',
            'created_at' => Carbon::now()->subHours(3)->subMinutes(9),
        ]);
    }
}
