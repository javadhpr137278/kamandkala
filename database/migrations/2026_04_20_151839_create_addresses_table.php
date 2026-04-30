<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->comment('عنوان آدرس');
            $table->string('type')->default('custom')->comment('نوع آدرس: billing, shipping, custom');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->default('ایران');
            $table->string('plaque')->nullable();
            $table->string('unit')->nullable();
            $table->string('order_number')->nullable()->comment('شماره سفارش مرتبط');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
