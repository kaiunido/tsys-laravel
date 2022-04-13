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
    Schema::create('stocks', function (Blueprint $table) {
      $table->id();
      $table->foreignId('nf_id')->nullable();
      $table->foreignId('product_id');
      $table->integer('quantity')->default(1);
      $table->integer('quantity_sold')->default(0);
      $table->boolean('has_stock')->default(1);
      $table->decimal('price', 15, 4)->default(0.0000);
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
    Schema::dropIfExists('stocks');
  }
};
