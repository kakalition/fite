<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('public_workouts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('author_id')
        ->references('id')
        ->on('users')
        ->cascadeOnDelete();
      $table->integer('total_saved')->default(0);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('public_workouts');
  }
};
