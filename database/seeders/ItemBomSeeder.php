<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ItemBomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bom = [
            'item_id'=>'1', 'rm_id'=>'1','qty'=>'10','unit'=>'kg'
        ];

        DB::table('item_boms')->insert($bom);
    }
}
