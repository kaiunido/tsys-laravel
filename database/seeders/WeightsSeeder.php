<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeightsSeeder extends Seeder
{
    /**
     * Array with default system weights.
     *
     * @var array
     */
    protected $weights = [
        ['name' => 'Kilograma', 'unit' => 'kg', 'value' => 1],
        ['name' => 'Grama', 'unit' => 'g', 'value' => 1000],
        ['name' => 'Libra', 'unit' => 'lb', 'value' => 2.2046],
        ['name' => 'Onça', 'unit' => 'oz', 'value' => 35.274],
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

        foreach ($this->weights as &$value) {
            $id = DB::table('weights')->insertGetId([
                'value' => $value['value'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::table('weight_descriptions')->insert([
                'weight_id' => $id,
                'language_id' => $language->id,
                'name' => $value['name'],
                'unit' => $value['unit'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
