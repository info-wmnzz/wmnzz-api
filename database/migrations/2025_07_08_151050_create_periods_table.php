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
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->date('periods_last_date');
            $table->date('periods_end_date');
            $table->tinyInteger('status')->default(1);
            $table->string('cramps_days')->nullable(); // Number of days with cramps
            $table->integer('cycle_length')->default(28);
            $table->integer('period_length')->default(5);  
            $table->integer('flow')->default(0);
            $table->date('ovulation')->nullable();
            $table->date('fertile_window_start')->nullable();
            $table->date('fertile_window_end')->nullable();
            $table->date('next_period_date')->nullable();
            $table->integer('luteal_phase')->default(0);
            $table->integer('period_type')->default(0); // 0: Regular, 1: Irregular, 2: Spotting
            $table->integer('period_color')->default(0); // 0: Light, 1: Medium, 2: Dark
            $table->integer('period_intensity')->default(0); // 0: Light, 1: Medium, 2: Heavy
            $table->integer('period_pain')->default(0); // 0: None, 1: Mild, 2: Moderate
            $table->integer('period_flow')->default(0); // 0: Light, 1: Medium, 2: Heavy
            $table->integer('period_duration')->default(0); // Duration in days
            $table->integer('period_notes')->nullable(); // Additional notes or comments
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
