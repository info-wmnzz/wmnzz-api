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
        Schema::create('periods_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->string('mood')->nullable();
            $table->string('symptoms')->nullable();
            $table->integer('flow')->default(0); // 0: Light, 1: Medium, 2: Heavy
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods_reactions');
    }
};
