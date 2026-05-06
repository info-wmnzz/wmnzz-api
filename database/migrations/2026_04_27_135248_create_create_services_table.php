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
        Schema::create('create_services', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_provider_id')->nullable();

            $table->string('service_title');
            $table->string('service_category');
            $table->string('city_of_operation');
            $table->text('service_desc');

            $table->decimal('price', 10, 2);
            $table->integer('experience');

            $table->string('image')->nullable();
            $table->string('status')->default(0);

            $table->text('service_provider_address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode', 10)->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();

            $table->foreign('service_provider_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_services');
    }
};
