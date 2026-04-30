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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->constrained();
            $table->foreignId('guaranty_id')->constrained();

            $table->decimal('main_price', 15, 2); // قیمت اصلی
            $table->decimal('discount_price', 15, 2)->default(0); // قیمت نهایی با تخفیف
            $table->integer('discount_percent')->default(0); // درصد تخفیف

            $table->integer('stock')->default(0); // موجودی
            $table->integer('max_sell')->nullable(); // حداکثر فروش در سبد خرید
            $table->string('sku')->unique(); // کد کالا (Stock Keeping Unit)

            $table->boolean('is_special')->default(false);
            $table->timestamp('special_expiration')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
