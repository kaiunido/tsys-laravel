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
    Schema::create('length_descriptions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('length_id')
        ->constrained()
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
      $table->foreignId('language_id');
      $table->string('name');
      $table->string('unit', 3);
      $table->timestamps();
      $table->softDeletes();

      $table->unique(['length_id', 'language_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('length_descriptions');
  }
};
