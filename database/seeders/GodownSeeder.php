<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GodownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $godowns = [
            ['name' => 'COMPANY', 'address' => 'C16', 'mobile_no' => '9823441662', 'isdeleted' => 0],
            ['name' => '182 CHINCHOLI', 'address' => 'JALGAON', 'mobile_no' => '9823441662', 'isdeleted' => 0],
            ['name' => 'WALUJ DEPO', 'address' => 'WALUJ', 'mobile_no' => '9923576566', 'isdeleted' => 0]
        ];
        DB::table('godowns')->insert($godowns);
    }
}
