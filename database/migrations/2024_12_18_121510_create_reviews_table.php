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
        Schema::create(
            'reviews',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedSmallInteger('rating');
                $table->text('content');
                $table->json('images_urls')->nullable();
                $table->foreignId('user_id')
                      ->index()
                      ->constrained('users')
                      ->cascadeOnUpdate()
                      ->cascadeOnDelete();
                $table->foreignId('product_id')
                      ->index()
                      ->constrained('products')
                      ->cascadeOnUpdate()
                      ->cascadeOnDelete();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
