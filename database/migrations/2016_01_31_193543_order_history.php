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
            $table->integer('owner')->unsigned()->default(0);
            $table->foreign('owner')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();

        });

        Schema::create('order_history-products', function(Blueprint $table)
        {

            $table->integer('order_history_id')->unsigned()->index();
            $table->foreign('order_history_id')
                ->references('id')
                ->on('order_history')
                ->onDelete('cascade');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
