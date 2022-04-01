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
      $table->id();
      $table->string('model')->nullable();
      $table->string('sku')->nullable();
      $table->string('upc')->nullable();
      $table->string('ean')->nullable();
      $table->string('jan')->nullable();
      $table->string('isbn')->unique()->nullable();
      $table->string('mpn')->nullable();
      $table->string('location')->nullable();
      $table->integer('quantity')->nullable();
      $table->foreignId('stock_status_id')->constrained();
      $table->string('image')->nullable();
      $table->foreignId('manufacturer_id')->constrained()->nullable();
      $table->boolean('shipping')->default(1);
      $table->decimal('price', 15, 4)->default(0.0000);
      $table->integer('points')->nullable();
      $table->timestamp('date_available')->default(now());
      $table->decimal('weight', 15, 8)->default(0.00000000);
      $table->foreignId('weight_id')->constrained();
      $table->decimal('length', 15, 8)->default(0.00000000);
      $table->decimal('width', 15, 8)->default(0.00000000);
      $table->decimal('height', 15, 8)->default(0.00000000);
      $table->foreignId('length_id')->constrained();
      $table->boolean('subtract')->default(1);
      $table->integer('minimum')->default(1);
      $table->integer('sort_order')->default(0);
      $table->boolean('status')->default(0);
      $table->integer('viewed')->default(0);
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
    Schema::dropIfExists('products');
  }
};
