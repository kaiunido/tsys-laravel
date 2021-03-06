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
    Schema::create('weights_descriptions', function (Blueprint $table) {
      $table->foreignId('weight_id');
      $table->foreignId('language_id');
      $table->string('name');
      $table->string('unit', 3);
      $table->timestamps();
      $table->softDeletes();

      $table->unique(['weight_id', 'language_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('weights_descriptions');
  }
};
