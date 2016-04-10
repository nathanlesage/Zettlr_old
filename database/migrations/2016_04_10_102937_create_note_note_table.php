<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Let the inception begin
        Schema::create('note_note', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('note1_id')->unsigned();
            $table->foreign('note1_id')->references('id')->on('notes');
            $table->integer('note2_id')->unsigned();
            $table->foreign('note2_id')->references('id')->on('notes');
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
        Schema::drop('note_note');
    }
}
