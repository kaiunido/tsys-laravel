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
    Schema::create('products', function (Blueprint $table) {
      $table->id('product_id');
      $table->string('model')->nullable();
      $table->string('sku')->nullable();
      $table->string('upc')->nullable();
      $table->string('ean')->nullable();
      $table->string('jan')->nullable();
      $table->string('isbn')->nullable();
      $table->string('mpn')->nullable();
      $table->string('location')->nullable();
      $table->integer('quantity')->nullable();
      $table->foreignId('stock_status_id')->nullable();
      $table->string('image')->nullable();
      $table->foreignId('manufacturer_id')->nullable();
      $table->boolean('shipping')->default(1);
      $table->decimal('price', $precision = 15, $scale = 4)->default(0.0000);
      $table->integer('points')->nullable();
      $table->foreignId('tax_class_id');
      $table->timestamp('date_available', $precision = 0)->default(now());
      $table->decimal('weight', $precision = 15, $scale = 4)->default(0.00000000);
      $table->foreignId('weight_class_id');
      $table->decimal('length', $precision = 15, $scale = 4)->default(0.00000000);
      $table->decimal('width', $precision = 15, $scale = 4)->default(0.00000000);
      $table->decimal('height', $precision = 15, $scale = 4)->default(0.00000000);
      $table->foreignId('length_class_id');
      $table->boolean('subtract')->default(1);
      $table->integer('minimum')->default(1);
      $table->integer('sort_order')->default(0);
      $table->boolean('status')->default(0);
      $table->integer('viewed')->default(0);
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
    Schema::dropIfExists('products');
  }
};
