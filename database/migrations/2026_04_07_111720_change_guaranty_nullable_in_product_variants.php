<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreignId('guaranty_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreignId('guaranty_id')->nullable(false)->change();
        });
    }

};
