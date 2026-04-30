<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // تغییر نوع ستون از enum به string
            $table->string('payment_method', 50)->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // برگرداندن به حالت قبل (با مقادیر enum)
            $table->enum('payment_method', ['bacs', 'cod'])->default('bacs')->change();
        });
    }
};
