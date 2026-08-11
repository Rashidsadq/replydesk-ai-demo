<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;

class DemoAiService
{
    /**
     * Process simulated or typed customer message in a conversation.
     */
    public function respond(Conversation $conversation, string $userText): Message
    {
        // Record customer message
        $customerMsg = Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_name' => $conversation->customer->name,
            'content' => $userText,
        ]);

        $lower = mb_strtolower(trim($userText));

        $aiText = '';
        $isBooking = false;
        $bookingDetails = null;

        // 1. Arabic or English Time Choice Selection
        if (in_array($lower, ['6:00 pm', '6:00', '6pm', '6:00pm', '6:30 pm', '6:30', '630pm', '6:30pm', '6:00 مساءً', '6:00 مساء', '6 مساءً', 'الساعة 6']) || str_contains($lower, 'prefer 6') || str_contains($lower, 'book 6') || str_contains($lower, 'فضل 6')) {
            $timeSlot = (str_contains($lower, '6:30') || str_contains($lower, '630')) ? '6:30 PM' : '6:00 PM';
            $isArabicQuery = str_contains($lower, 'مساء') || str_contains($lower, 'حجز') || str_contains($lower, 'درهم') || session('locale') === 'ar';

            if ($isArabicQuery) {
                $aiText = "ممتاز! تم حجز موعد قص الشعر الخاص بك اليوم الساعة 6:00 مساءً مع أحمد حسن. ✅";
            } else {
                $aiText = "Perfect! Your haircut is booked for today at {$timeSlot} with Ahmed Hassan. ✅";
            }

            $isBooking = true;
            $bookingDetails = [
                'service' => $isArabicQuery ? 'قص شعر' : 'Haircut',
                'price' => '80 AED',
                'duration' => '30 mins',
                'time' => $isArabicQuery ? 'اليوم، 6:00 مساءً' : "Today, {$timeSlot}",
                'staff' => 'Ahmed Hassan',
                'status' => 'Confirmed',
            ];

            $service = Service::where('name', 'Haircut')->first() ?? Service::first();
            $staff = Staff::where('name', 'Ahmed Hassan')->first() ?? Staff::first();

            Appointment::create([
                'customer_id' => $conversation->customer_id,
                'service_id' => $service->id,
                'staff_id' => $staff->id,
                'appointment_date' => Carbon::today(),
                'time_slot' => $timeSlot,
                'status' => 'confirmed',
                'booked_by_ai' => true,
            ]);

            $conversation->update(['status' => 'ai_active', 'summary' => $conversation->customer->name . ' — Booked Haircut ' . $timeSlot . ' — ReplyDesk AI']);
        }
        // 2. Booking Inquiry ("I want to book tomorrow at 6 PM" or "حجز غداً الساعة 6")
        elseif (str_contains($lower, 'want to book') || str_contains($lower, 'book tomorrow') || str_contains($lower, 'book at 6') || str_contains($lower, 'tomorrow at 6') || str_contains($lower, 'حجز') || str_contains($lower, 'غداً الساعة 6')) {
            if (str_contains($lower, 'حجز') || str_contains($lower, 'ساعة') || session('locale') === 'ar') {
                $aiText = "لدينا موعد متاح الساعة 6:00 مساءً والساعة 6:30 مساءً مع أحمد حسن. أيهما تفضل؟";
            } else {
                $aiText = "I have 6:00 PM and 6:30 PM available today with Ahmed Hassan. Which one would you prefer?";
            }
        }
        // 3. Price Inquiries ("how much", "price", "cost", "كم سعر")
        elseif (str_contains($lower, 'how much') || str_contains($lower, 'price') || str_contains($lower, 'cost') || str_contains($lower, 'sعر') || str_contains($lower, 'كم سعر')) {
            if (str_contains($lower, 'beard') || str_contains($lower, 'لحية')) {
                if (session('locale') === 'ar' || str_contains($lower, 'سعر') || str_contains($lower, 'لحية')) {
                    $aiText = "مرحباً بك 👋 سعر تشذيب اللحية 40 درهم إماراتي وتستغرق 20 دقيقة. هل ترغب في حجز موعد؟";
                } else {
                    $aiText = "Hi 👋 Our Beard Trim is AED 40 and takes 20 minutes. Would you like to book an appointment?";
                }
            } else {
                if (session('locale') === 'ar' || str_contains($lower, 'سعر') || str_contains($lower, 'حلاقة')) {
                    $aiText = "سعر الحلاقة 80 درهم وتستغرق حوالي 30 دقيقة. هل ترغب في حجز موعد؟";
                } else {
                    $aiText = "Hi 👋 Our haircut is AED 80 and takes around 30 minutes. Would you like to book an appointment?";
                }
            }
        }
        // 4. Opening Hours Inquiries ("open", "timing", "hours", "ساعات", "مفتوح")
        elseif (str_contains($lower, 'open') || str_contains($lower, 'timing') || str_contains($lower, 'hours') || str_contains($lower, 'ساعات') || str_contains($lower, 'مفتوح')) {
            if (session('locale') === 'ar' || str_contains($lower, 'مفتوح') || str_contains($lower, 'ساعات')) {
                $aiText = "نحن نعمل طوال أيام الأسبوع من الساعة 10:00 صباحاً حتى 10:00 مساءً في دبي مارينا! هل ترغب في معرفة المواعيد المتاحة؟";
            } else {
                $aiText = "We are open 7 days a week from 10:00 AM to 10:00 PM at Dubai Marina! Would you like to check available slots for today or tomorrow?";
            }
        }
        // 5. Human Request ("speak to someone", "human", "agent", "شخص", "موظف")
        elseif (str_contains($lower, 'speak') || str_contains($lower, 'someone') || str_contains($lower, 'human') || str_contains($lower, 'agent') || str_contains($lower, 'شخص') || str_contains($lower, 'موظف')) {
            $conversation->update(['status' => 'human_handling', 'summary' => $conversation->customer->name . ' — Special Request — Human needed']);
            if (session('locale') === 'ar' || str_contains($lower, 'شخص') || str_contains($lower, 'موظف')) {
                $aiText = "جاري تحويل محادثتك إلى أحد موظفي الصالون فوراً. سيتواصل معك أحد الحلاقين قريباً! 👨‍💼";
            } else {
                $aiText = "I am transferring you to a human staff member right away. One of our barbers will reply to you shortly! 👨‍💼";
            }
        }
        // Fallback
        else {
            if (session('locale') === 'ar') {
                $aiText = "أهلاً بك في صالون النخبة باربر دبي! يمكنني مساعدتك في معرفة الأسعار، أو حجز موعد، أو التأكد من مواعيد الحلاقين. ما هي الخدمة التي ترغب بها اليوم؟";
            } else {
                $aiText = "Thank you for reaching out to Elite Barber Dubai! I can assist you with pricing, appointment bookings, or staff availability. What service are you interested in today?";
            }
        }

        // Record AI response message
        $aiMsg = Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'ai',
            'sender_name' => 'ReplyDesk AI',
            'content' => $aiText,
            'is_booking_confirmation' => $isBooking,
            'booking_details' => $bookingDetails,
        ]);

        $conversation->update([
            'last_message' => $aiText,
            'last_message_at' => Carbon::now(),
        ]);

        return $aiMsg;
    }
}
