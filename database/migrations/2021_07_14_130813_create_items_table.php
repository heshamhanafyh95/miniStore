<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('tradePrice', 8, 2);
            $table->float('customerPrice', 8, 2);
            $table->float('minPrice', 8, 2);
            $table->integer('quantity')->unsigned();
            $table->string('image')->nullable();
            $table->float('discount', 3, 2)->default(0);
            $table->integer('status')->default(1);

            $table->integer('categoryId')->unsigned();
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
