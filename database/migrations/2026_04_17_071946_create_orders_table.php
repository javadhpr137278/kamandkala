<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_phone');
            $table->string('billing_email')->nullable();
            $table->string('billing_address_1')->nullable();
            $table->string('billing_address_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postcode')->nullable();
            $table->string('billing_country')->default('IR');

            // Shipping address fields (if different from billing)
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address_1')->nullable();
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_country')->default('IR');

            // Custom address fields
            $table->text('custom_address')->nullable();
            $table->string('custom_city')->nullable();
            $table->string('custom_postcode')->nullable();

            // Address choice type: billing, shipping, custom
            $table->enum('address_choice', ['billing', 'shipping', 'custom'])->default('billing');

            // Shipping date
            $table->date('shipping_date')->nullable();

            // Order items (JSON)
            $table->json('order_items')->nullable();

            // Totals
            $table->decimal('subtotal', 15, 0)->default(0);
            $table->decimal('shipping_cost', 15, 0)->default(0);
            $table->decimal('total', 15, 0)->default(0);

            // Payment method
            $table->enum('payment_method', ['bacs', 'cod'])->default('bacs');

            // Order status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'cancelled',
                'failed'
            ])->default('pending');

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('order_number');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
