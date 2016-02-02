<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->default(0);
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('name')->unique();
            $table->float('price')->default(0);
            $table->string('description');
            $table->string('slug')->unique();
            $table->integer('category_id');
            $table->integer('quantity')->unsigned()->default(0);
            $table->boolean('active')->default(1);
            $table->bigInteger('views')->default(0);
            $table->bigInteger('likes')->unsigned()->default(0);
            $table->bigInteger('dislikes')->unsigned()->default(0);
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
        Schema::drop('products');
    }
}
