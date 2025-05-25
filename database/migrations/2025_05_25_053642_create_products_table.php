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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 30)->unique()->index();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('slug', 100)->nullable()->unique()->index();
            $table->string('desc', 150)->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1-Active, 0-Inactive');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
