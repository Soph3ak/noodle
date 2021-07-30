<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_kh');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('pro_discount')->default(0);
            $table->string('photo')->nullable();
            $table->tinyInteger('qty')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreignId('category_id')
                ->constrained('categories')
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
        Schema::dropIfExists('products');
    }
}
