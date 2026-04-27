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
        Schema::create('seller_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('seller_id')->index();
            $table->string('name', 100)->nullable();
            $table->string('brand_name')->nullable();
            $table->string('slug', 100)->nullable()->unique()->index();
            $table->string('desc', 150)->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->decimal('mrp_price', 10, 2)->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_products');
    }
};
