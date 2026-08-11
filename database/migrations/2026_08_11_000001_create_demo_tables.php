<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('duration_minutes');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->default('Barber Specialist');
            $table->string('avatar_url')->nullable();
            $table->json('services')->nullable();
            $table->string('working_hours')->default('10:00 AM - 10:00 PM');
            $table->string('status')->default('available'); // available, busy, off
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('avatar_url')->nullable();
            $table->string('status')->default('Active'); // Active, Lead, VIP
            $table->text('notes')->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();
        });

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('ai_active'); // ai_active, human_handling, resolved
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->integer('unread_count')->default(0);
            $table->string('summary')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->string('sender_type'); // customer, ai, staff
            $table->string('sender_name')->nullable();
            $table->text('content');
            $table->text('content_ar')->nullable();
            $table->boolean('is_booking_confirmation')->default(false);
            $table->json('booking_details')->nullable();
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained()->onDelete('cascade');
            $table->date('appointment_date');
            $table->string('time_slot');
            $table->string('status')->default('confirmed'); // confirmed, pending, cancelled, completed
            $table->boolean('booked_by_ai')->default(true);
            $table->timestamps();
        });

        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Elite Barber Dubai');
            $table->string('tagline')->default('Your AI receptionist for WhatsApp.');
            $table->string('location')->default('Dubai Marina, Dubai');
            $table->string('phone')->default('+971 4 555 0188');
            $table->string('opening_hours')->default('10:00 AM - 10:00 PM');
            $table->string('currency')->default('AED');
            $table->string('language')->default('en'); // en, ar
            $table->boolean('ai_enabled')->default(true);
            $table->json('capabilities')->nullable();
            $table->json('rules')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_settings');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('services');
    }
};
