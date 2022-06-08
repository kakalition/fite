<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('exercises', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')
        ->references('id')
        ->on('users')
        ->cascadeOnDelete();
      $table->string('title');
      $table->integer('type');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('exercises');
  }
};
