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
            $table->string('fullname')->index(); // Index for faster search
            $table->text('pickup_address', 1000);
            $table->text('delivery_address', 1000);
            $table->text('item_description');
            $table->string('status')->default('Pending')->index(); // Commonly filtered
            $table->string('customer_phone')->index(); // Search optimization
            $table->string('customer_email')->nullable();
            $table->string('delivery_type')->default('Standard');
            $table->string('delivery_time_slot')->nullable();
            $table->decimal('distance', 8, 2)->nullable();
            $table->timestamp('estimated_delivery_time')->nullable();
            $table->timestamp('actual_delivery_time')->nullable();
            $table->decimal('package_weight', 8, 2)->nullable();
            $table->string('package_dimensions')->nullable();
            $table->boolean('is_fragile')->default(false);
            $table->text('special_instructions')->nullable();
            $table->string('payment_status')->default('Unpaid')->index(); // Payment tracking
            $table->string('payment_method')->nullable();
            $table->decimal('total_cost', 8, 2);
            $table->decimal('discount', 8, 2)->default(0);
            $table->unsignedBigInteger('rider_id')->nullable()->index(); // Rider queries
            $table->foreign('rider_id')->references('id')->on('riders');
            $table->text('rider_notes')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable()->index(); // Admin queries
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->unsignedBigInteger('user_id')->nullable()->index(); // User-specific queries
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('pickup_time')->nullable()->index(); // Sorting by pickup time
            $table->integer('delivery_attempts')->default(0);
            $table->text('failed_delivery_reason')->nullable();
            $table->string('order_source')->default('Website');
            $table->string('order_priority')->default('Medium')->index(); // Prioritization
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('scheduled_pickup_time')->nullable();
            $table->timestamp('scheduled_delivery_time')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            // Compound Index (For better filtering on orders)
            $table->index(['status', 'payment_status']);
            $table->index(['pickup_time', 'scheduled_delivery_time']);
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
