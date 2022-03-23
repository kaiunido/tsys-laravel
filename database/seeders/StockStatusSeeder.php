<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockStatusSeeder extends Seeder
{
  /**
   * Array with default system stock status.
   * 
   * @var array
   */
  protected $stockStatus = [
    ['name' => 'Em Estoque'],
    ['name' => 'Fora de Estoque'],
    ['name' => 'Encomenda'],
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $language = DB::table('languages')
      ->select('id')
      ->where('code', 'pt-br')
      ->first();

    foreach ($this->stockStatus as &$value) {
      $value['language_id'] = $language->id;
      $value['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
    }

    DB::table('stock_statuses')->insert($this->stockStatus);
  }
}
