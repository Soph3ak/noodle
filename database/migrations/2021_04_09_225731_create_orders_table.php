<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('customer_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('table_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('shop_id')
                ->constrained()
                ->onDelete('cascade');

            $table->bigInteger('subtotal');
            $table->bigInteger('discount');
            $table->bigInteger('total');

            $table->foreignId('payment_id')
                ->constrained()
                ->onDelete('cascade');

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
        Schema::dropIfExists('orders');
    }
}
