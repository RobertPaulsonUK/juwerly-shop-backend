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
        Schema::dropIfExists('product_stocks');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->integer('percent_discount')->nullable();
            $table->float('fixed_discount')->nullable();
            $table->float('threshold')->nullable();
            $table->boolean('all_products')->default(true);
            $table->json('category_ids')->nullable();
            $table->json('product_ids')->nullable();
            $table->foreignId('gift_product')
                  ->nullable()
                  ->index()
                  ->constrained('products');
            $table->timestamps();
        });
    }
};
