<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_promotion', function (Blueprint $table) {

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            $table->foreignId('promotion_id')
                ->constrained('promotions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_promotion');
    }
}
