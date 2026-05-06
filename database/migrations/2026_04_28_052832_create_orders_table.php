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
            $table->string('order_id', 100)->unique();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name', 150);
            $table->tinyInteger('order_status')->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->dateTime('order_date_time');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->nullOnDelete();
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
