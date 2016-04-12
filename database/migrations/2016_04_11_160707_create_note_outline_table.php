<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteOutlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('note_outline', function(Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->integer('note_id')->unsigned();
          $table->foreign('note_id')->references('id')->on('notes');
          $table->integer('outline_id')->unsigned();
          $table->foreign('outline_id')->references('id')->on('outlines');
          // Custom pivot field: index
          $table->integer('index')->unsigned();
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
        Schema::drop('note_outline');
    }
}
