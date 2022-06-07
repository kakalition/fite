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
    Schema::create('saved_workouts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')
        ->references('id')
        ->on('users')
        ->cascadeOnDelete();
      $table->string('title');
      $table->foreignId('public_workout_id')
        ->nullable()
        ->references('id')
        ->on('public_workouts')
        ->cascadeOnDelete();
      $table
        ->json('exercises')
        ->nullable()
        ->constrained();
      $table->timestamps();
    });

    Schema::table('public_workouts', function (Blueprint $table) {
      $table->foreignId('saved_workout_id')
        ->references('id')
        ->on('saved_workouts')
        ->cascadeOnDelete()
        ->after('id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('saved_workouts');
  }
};
