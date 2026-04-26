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
        Schema::create('seller_business_details', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('business_category');
            $table->string('gst_number', 15)->nullable();
            $table->string('cin', 21)->nullable();
            $table->string('store_email')->unique();
            $table->string('store_phone', 15);
            $table->text('business_address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_business_details');
    }
};
