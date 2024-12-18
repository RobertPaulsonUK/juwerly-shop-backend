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
        Schema::create('crossells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_product')
                  ->index()
                  ->constrained('products')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignId('crossell')
                  ->index()
                  ->constrained('products')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crossells');
    }
};
