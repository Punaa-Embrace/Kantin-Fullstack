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
            $table->string('order_code')->unique();
            $table->foreignId('student_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('restrict');
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_method', ['qris', 'cash']);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('order_status', ['pending_approval', 'rejected', 'preparing', 'ready_to_pickup', 'completed'])->default('pending_approval');
            $table->text('student_notes')->nullable();
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
