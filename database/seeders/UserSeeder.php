<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
  /**
   * Array with default system user.
   * 
   * @var array
   */
  protected $user = [];

  public function __construct()
  {
    $this->user = [
      'name' => 'Admin',
      'email' => 'admin@teccompany.com.br',
      'password' => bcrypt('secret'),
      'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert($this->user);
  }
}
