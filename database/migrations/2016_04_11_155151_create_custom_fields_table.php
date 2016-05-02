<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('custom_fields', function(Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->String('type', 255);
          $table->Text('content');
          $table->integer('outline_id')->unsigned();
          $table->foreign('outline_id')->references('id')->on('outlines')->onDelete('cascade');
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
        Schema::drop('custom_fields');
    }
}
