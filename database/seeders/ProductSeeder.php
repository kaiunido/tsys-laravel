<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Seo;
use App\Models\Stock;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    for ($i = 0; $i < 50; $i++) {
      Product::factory(1)
        ->hasDescription(1)
        ->hasSeo(1)
        ->hasStock(random_int(1, 4))
        ->create();
    }
  }
}
