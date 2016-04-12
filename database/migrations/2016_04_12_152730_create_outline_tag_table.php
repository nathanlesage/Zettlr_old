<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutlineTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('outline_tag', function(Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->integer('tag_id')->unsigned();
          $table->foreign('tag_id')->references('id')->on('tags');
          $table->integer('outline_id')->unsigned();
          $table->foreign('outline_id')->references('id')->on('outlines');
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
        Schema::drop('outline_tag');
    }
}
