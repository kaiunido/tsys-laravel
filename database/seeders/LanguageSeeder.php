<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LanguageSeeder extends Seeder
{
  /**
   * Array with default system languages.
   * 
   * @var array
   */
  protected $languages = [];

  public function __construct()
  {
    $this->languages = [
      [
        'name' => 'Português (BR)',
        'code' => 'pt-br',
        'locale' => 'pt-BR',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ],
      [
        'name' => 'English',
        'code' => 'en',
        'locale' => 'en',
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]
    ];
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    foreach ($this->languages as $language) {
      DB::table('languages')->insert($language);
    }
  }
}
