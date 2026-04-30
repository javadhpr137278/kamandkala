<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->foreignId('color_id')->constrained()->onDelete('cascade');
            $table->foreignId('guaranty_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 0)->nullable(); // برای ذخیره قیمت لحظه افزودن
            $table->timestamps();

            // ایندکس ترکیبی برای جلوگیری از duplicate
            $table->unique(['user_id', 'product_id', 'variant_id'], 'cart_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
