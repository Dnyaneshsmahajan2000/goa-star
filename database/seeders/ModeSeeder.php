<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes=[
            ['value'=>'Cash'],
            ['value' => 'Google Pay'],
            ['value' => 'Phone pay'],
            ['value' => 'Paytm'],
        ];
        DB::table('modes')->insert($modes);
    }
}
