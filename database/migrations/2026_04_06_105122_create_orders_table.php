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
             $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_number')->unique(); // contoh: ORD-20240601-0001
            $table->enum('status', [
                'pending',
                'paid',
                'verified',
                'shipped', 
                'completed', 
                'cancelled',
            ])->default('pending');
            $table->decimal('total_amount', 12, 2);
            $table->text('shipping_address');
            $table->string('recipient_name');
            $table->string('recipient_phone', 20);
            $table->text('notes')->nullable(); 
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
