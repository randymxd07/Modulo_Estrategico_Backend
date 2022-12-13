<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{

    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 100);
            $table->decimal('percent');
            $table->unsignedBigInteger('number_of_days');
            $table->foreignId('product_category_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('color')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes()->nullable();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }

}
