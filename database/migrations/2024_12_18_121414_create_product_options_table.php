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
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->index()
                  ->constrained('products')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignId('option_id')
                  ->index()
                  ->constrained('attribute_options')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->foreignId('attribute_id')
                  ->index()
                  ->constrained('attributes')
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
        Schema::dropIfExists('product_options');
    }
};
