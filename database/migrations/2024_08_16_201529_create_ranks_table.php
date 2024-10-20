<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description')->nullable();
            $table->string('icon');
            $table->boolean('status')->default(true);
            $table->integer('min_purchase');
            $table->boolean('is_special_price')->default(false);
            $table->boolean('is_coupon')->default(false);
            $table->integer('discount_value')->nullabe();
            // $table->coupon_value('discount_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranks');
    }
};
