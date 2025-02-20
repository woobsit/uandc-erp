<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riders', function (Blueprint $table) {
            // Personal Information
            $table->id();
            $table->string('full_name');
            $table->string('phone_number')->unique();
            $table->string('email')->unique()->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_photo')->nullable();

            // Vehicle Information
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_color')->nullable();

            // Work Details
            $table->string('rider_status')->default('Active');
            $table->boolean('availability')->default(true);
            $table->date('joining_date')->nullable();
            $table->text('work_zone')->nullable();
            $table->decimal('rider_rating', 3, 2)->default(0.00);
            $table->integer('total_deliveries')->default(0);
            $table->decimal('on_time_delivery_rate', 5, 2)->default(0.00);

            // Financial Information
            $table->string('payment_method')->nullable();
            $table->text('bank_account_details')->nullable();
            $table->decimal('earnings', 10, 2)->default(0.00);

            // Additional Metadata
            $table->text('notes')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riders');
    }
};
