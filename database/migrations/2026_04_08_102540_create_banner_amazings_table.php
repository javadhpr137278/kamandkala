<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banner_amazings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('festival_title')->nullable();
            $table->text('festival_description')->nullable();

            $table->integer('discount_percent')->nullable();

            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();

            $table->string('image')->nullable();

            $table->json('colors')->nullable(); // پالت رنگ

            $table->string('button_text')->default('مشاهده و خرید');
            $table->string('button_link')->default('/shop');

            $table->timestamp('countdown_end')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_amazings');
    }
};
