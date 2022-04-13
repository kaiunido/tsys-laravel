<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LengthsSeeder extends Seeder
{
  /**
   * Array with default system lengths.
   * 
   * @var array
   */
  protected $lengths = [
    ['name' => 'Centimetro', 'unit' => 'cm', 'value' => 1],
    ['name' => 'Milimetro', 'unit' => 'mm', 'value' => 10],
    ['name' => 'Polegada', 'unit' => 'in', 'value' => 0.3937],
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

    foreach ($this->lengths as &$value) {
      $id = DB::table('lengths')->insertGetId([
        'value' => $value['value'],
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]);

      DB::table('lengths_descriptions')->insert([
        'length_id' => $id,
        'language_id' => $language->id,
        'name' => $value['name'],
        'unit' => $value['unit'],
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]);
    }
  }
}
