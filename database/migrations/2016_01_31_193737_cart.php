<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('total_price');
            $table->integer('owner')->unsigned()->default(0);
            $table->foreign('owner')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();

        });

        Schema::create('cart_product', function(Blueprint $table)
        {
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->integer('cart_id')->unsigned()->index();
            $table->foreign('cart_id')
                ->references('id')
                ->on('cart')
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
        Schema::drop('cart');
        Schema::drop('cart_product');
    }
}
