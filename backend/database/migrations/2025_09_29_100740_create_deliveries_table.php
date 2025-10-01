<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('pending'); // pending, picked_up, on_the_way, arrived, completed, cancelled
            $table->decimal('current_latitude', 10, 8)->nullable();
            $table->decimal('current_longitude', 10, 8)->nullable();
            $table->string('current_address')->nullable();
            $table->timestamp('location_updated_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('on_the_way_at')->nullable();
            $table->timestamp('arrived_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
        });

        // Delivery status history
        Schema::create('delivery_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Delivery location history
        Schema::create('delivery_location_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 10, 8);
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_location_history');
        Schema::dropIfExists('delivery_status_history');
        Schema::dropIfExists('deliveries');
    }
};