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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('etitle');
            $table->string('slug');
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('count')->default(0);
            $table->integer('max_sell')->nullable();
            $table->integer('viewed')->default(0);
            $table->integer('sold')->default(0);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('guaranty_id')->nullable();
            $table->string('code_kala')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_special')->default(false);
            $table->timestamp('special_expiration')->nullable();
            $table->string('status')->default(\App\Enums\ProductStatus::Waiting->value);
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_tag', function (Blueprint $table) {

            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
