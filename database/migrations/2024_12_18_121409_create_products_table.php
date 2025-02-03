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
            $table->string('name');
            $table->string('article_number');
            $table->string('slug');
            $table->string('main_image_url');
            $table->json('gallery_urls')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('sale_price')->nullable();
            $table->boolean('is_hit')->default(false);
            $table->unsignedBigInteger('sale_counts')->default(0);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('rating')->nullable()->default(0);
            $table->foreignId('category_id')
                  ->nullable()
                  ->index()
                  ->constrained('product_categories')
                  ->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
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
