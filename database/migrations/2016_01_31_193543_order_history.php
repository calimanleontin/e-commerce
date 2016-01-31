<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_history',function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('owner');
            $table->foreign('owner')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();

        });

        Schema::create('order_history-product', function(Blueprint $table)
        {
            $table->integer('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->integer('order_history_id')
                ->references('id')
                ->on('order_history')
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
        Schema::drop('order_history');
    }
}
