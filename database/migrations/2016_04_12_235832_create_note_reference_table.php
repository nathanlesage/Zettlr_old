<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('note_reference', function(Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->integer('note_id')->unsigned();
          $table->foreign('note_id')->references('id')->on('notes');
          $table->integer('reference_id')->unsigned();
          $table->foreign('reference_id')->references('id')->on('references');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('note_reference');
    }
}
