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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->integer('active')->default(0);
            $table->string('firstname', 30);
            $table->string('surname', 30);
            $table->string('other_names', 30)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender', ['Male', 'Female']);
            $table->date('date_of_birth')->nullable();
            $table->text('address', 1000)->nullable();
            $table->string('phone', 11)->nullable();
            $table->string('photo')->default('storage/assets/images/users/default.jpg');
            $table->string('forget_password')->nullable();
            $table->string('expiry_timestamp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('admin_type_id')
                ->constrained()
                ->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
