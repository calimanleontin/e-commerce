<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('on_post')->unsigned()->default(0);
            $table->foreign('on_post')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->string('author_name');
            $table->int('author_id')->unsigned()->default(0);
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->text('content');
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
        //
    }
}
