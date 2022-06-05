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
      $table->integer('reps')->nullable();
      $table->integer('weights_in_kg')->nullable();
      $table->integer('durations_in_sec')->nullable();
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
