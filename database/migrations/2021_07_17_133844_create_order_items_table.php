<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->unsigned();
            $table->float('price', 8, 2);
            $table->integer('orderId')->unsigned();
            $table->foreign('orderId')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('itemId')->unsigned();
            $table->foreign('itemId')->references('id')->on('items')->onDelete('RESTRICT');
            $table->unique(['orderId', 'itemId']);
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
        Schema::dropIfExists('order_items');
    }
}
