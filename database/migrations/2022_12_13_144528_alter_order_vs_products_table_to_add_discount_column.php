<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('order_vs_products', function (Blueprint $table) {
            $table->decimal('discount')->nullable();
        });
    }

    public function down()
    {
        Schema::table('order_vs_products', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }

};
