<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            ['item_id' => 1, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 1, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 2, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 2, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 3, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 3, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 4, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 4, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 5, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 5, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 6, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 6, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 7, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 7, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 8, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 8, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 9, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 9, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 10, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 10, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 11, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 11, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 12, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 12, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 13, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 13, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 14, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 14, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 15, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 15, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 16, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 16, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 17, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 17, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 18, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 18, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 19, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 19, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 20, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 20, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 21, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 21, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 22, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 22, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 23, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 23, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 24, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 24, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 25, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 25, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 26, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 26, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 27, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 27, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 28, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 28, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 29, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 29, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 30, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 30, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 31, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 31, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 32, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 32, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 33, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 33, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 34, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 34, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 35, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 35, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 36, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 36, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 37, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 37, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 38, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 38, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 39, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 39, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 40, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 40, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 41, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 41, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 42, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 42, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 43, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 43, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 44, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 44, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 45, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 45, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 46, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 46, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 47, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 47, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 48, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 48, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 49, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 49, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 50, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 50, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 51, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 51, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 52, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 52, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 53, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 53, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 54, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 54, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 55, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 55, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 56, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 56, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 57, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 57, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 58, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 58, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 59, 'gd_id' => 1, 'unit' => '', 'quantity' => 0, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 59, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 60, 'gd_id' => 1, 'unit' => 50, 'quantity' => 2, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 1, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 5, 'gd_id' => 1, 'unit' => '', 'quantity' => -50, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 1, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 60, 'gd_id' => 1, 'unit' => '', 'quantity' => 100, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 60, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 60, 'gd_id' => 1, 'unit' => 0.99, 'quantity' => 100, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 2, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 5, 'gd_id' => 1, 'unit' => '', 'quantity' => -2009.1, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 2, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 2, 'gd_id' => 1, 'unit' => '', 'quantity' => -200.91, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 2, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 61, 'gd_id' => 1, 'unit' => '', 'quantity' => 1000, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 61, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 62, 'gd_id' => 1, 'unit' => '', 'quantity' => 100, 'rate' => null, 'value' => null, 'vch_type' => 'os', 'vch_no' => 62, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 62, 'gd_id' => 1, 'unit' => 1, 'quantity' => 100, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 3, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 61, 'gd_id' => 1, 'unit' => '', 'quantity' => -220, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 3, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['item_id' => 2, 'gd_id' => 1, 'unit' => '', 'quantity' => -110, 'rate' => null, 'value' => null, 'vch_type' => 'mfg', 'vch_no' => 3, 'machine_id' => null, 'created_by' => 1, 'updated_by' => 1],
        ];
        DB::table('stocks')->insert($stocks);
    }
}
