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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->foreignId('menu_id')
                  ->index()
                  ->constrained('menus')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('parent_id')
                  ->nullable()
                  ->index()
                  ->constrained('menu_items')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
