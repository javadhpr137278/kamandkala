<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('transaction_id')->unique(); // شناسه یکتا تراکنش داخلی
            $table->decimal('amount', 15, 0);
            $table->string('gateway'); // نام درگاه (zarinpal, idpay, ...)
            $table->enum('status', [
                'pending', 'processing', 'completed', 'failed', 'refunded'
            ])->default('pending');
            $table->string('reference_id')->nullable(); // کد رهگیری درگاه
            $table->string('tracking_code')->nullable(); // کد پیگیری بانک
            $table->string('card_number')->nullable(); // شماره کارت پرداخت کننده
            $table->json('payment_data')->nullable(); // داده‌های اضافی پرداخت
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('transaction_id');
            $table->index('reference_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
