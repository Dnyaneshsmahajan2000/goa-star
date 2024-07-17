<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units=[
            ['unit_name'=>'Nos','abbreviation'=>'nos'],
            ['unit_name'=>'Kilogram','abbreviation'=>'kg'],
            ['unit_name'=>'Gram','abbreviation'=>'g'],
            ['unit_name'=>'Tonne','abbreviation'=>'ton'],
            ['unit_name'=>'Quintal','abbreviation'=>'qtl'],
            ['unit_name'=>'Box','abbreviation'=>'box'],
            ['unit_name'=>'Liter','abbreviation'=>'ltr'],
            ['unit_name'=>'Mililiter','abbreviation'=>'ml'],
            ['unit_name'=>'Pack','abbreviation'=>'pack'],
          
        ];
        DB::table('units')->insert($units);
    }
}
