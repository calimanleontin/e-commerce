<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('author_id')->unsigned()->default(0);
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();

        });

        Schema::create('product_category', function(Blueprint $table)
        {
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::drop('categories');
        Schema::drop('product_category');

    }
}
