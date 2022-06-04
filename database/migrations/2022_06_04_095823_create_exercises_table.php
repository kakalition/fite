<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('exercises', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->integer('type');
      $table->integer('repetitions');
      $table->integer('weights_in_kg');
      $table->integer('durations_in_sec');
      $table->integer('rest_in_sec');
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
    Schema::dropIfExists('exercises');
  }
};
