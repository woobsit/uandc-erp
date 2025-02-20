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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->text('pickup_address', 1000);
            $table->text('delivery_address', 1000);
            $table->text('item_description');
            $table->string('status');

            // Customer Information
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            // Delivery Details
            $table->string('delivery_type')->default('Standard');
            $table->string('delivery_time_slot')->nullable();
            $table->decimal('distance', 8, 2)->nullable();
            $table->timestamp('estimated_delivery_time')->nullable();
            $table->timestamp('actual_delivery_time')->nullable();

            // Package Details
            $table->decimal('package_weight', 8, 2)->nullable();
            $table->string('package_dimensions')->nullable();
            $table->boolean('is_fragile')->default(false);
            $table->text('special_instructions')->nullable();

            // Payment Information
            $table->string('payment_status')->default('Unpaid');
            $table->string('payment_method')->nullable();
            $table->decimal('total_cost', 8, 2);
            $table->decimal('discount', 8, 2)->default(0);

            // Rider Information
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->foreign('rider_id')->references('id')->on('riders');
            $table->text('rider_notes')->nullable();

            // Order Tracking
            $table->timestamp('pickup_time')->nullable();
            $table->integer('delivery_attempts')->default(0);
            $table->text('failed_delivery_reason')->nullable();

            // Additional Metadata
            $table->string('order_source')->default('Website');
            $table->string('order_priority')->default('Medium');
            $table->text('cancellation_reason')->nullable();

            // Timestamps
            $table->timestamp('scheduled_pickup_time')->nullable();
            $table->timestamp('scheduled_delivery_time')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
