<?php
// database/migrations/2026_04_18_000002_add_shipping_date_persian_to_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'shipping_date_persian')) {
                $table->string('shipping_date_persian')->nullable()->after('shipping_date');
            }

            // تغییر نوع ستون payment_method از enum به string
            $table->string('payment_method', 50)->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_date_persian');
            $table->enum('payment_method', ['bacs', 'cod'])->default('bacs')->change();
        });
    }
};
