<?php

    use App\Models\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('status')
                  ->default(OrderStatus::ON_HOLD->value)
                  ->check("status IN ('on_hold', 'payment_completed', 'cancelled', 'delivery_completed')");

            $table->string('billing_name');
            $table->string('billing_surname');
            $table->string('billing_phone');
            $table->string('billing_email');
            $table->string('billing_delivery_method');
            $table->string('billing_delivery_city');
            $table->string('billing_delivery_area');
            $table->string('billing_delivery_address');
            $table->string('billing_payment_method');
            $table->foreignId('user_id')->nullable()->index()->constrained('users');
            $table->json('notice')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
