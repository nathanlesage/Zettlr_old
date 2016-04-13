<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutlineReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('outline_reference', function(Blueprint $table) {
        $table->increments('id');
        $table->timestamps();
        $table->integer('reference_id')->unsigned();
        $table->foreign('reference_id')->references('id')->on('references');
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
        Schema::drop('outline_reference');
    }
}
