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
    Schema::create('seo', function (Blueprint $table) {
      $table->id();
      $table->string('searchable_type');
      $table->foreignId('searchable_id');
      $table->foreignId('language_id');
      $table->string('meta_title');
      $table->string('meta_description');
      $table->string('meta_tags');
      $table->string('query');
      $table->string('meta_url');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('seo');
  }
};
