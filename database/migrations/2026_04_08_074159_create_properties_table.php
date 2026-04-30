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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('product_id')->constrained();
            $table->foreignId('property_groups_id')->constrained();
            $table->timestamps();
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->renameColumn('property_groups_id', 'property_group_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
