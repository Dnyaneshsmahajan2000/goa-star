<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machine = [
            ['name' => 'MACHINE 1'],
            ['name' => 'MACHINE 2'],
            ['name' => 'MACHINE 3'],
            ['name' => 'MACHINE 4'],
            ['name' => 'MACHINE 5'],
            ['name' => 'DANA MACHINE 1 ( BIG )'],
            ['name' => 'DANA MACHINE 2 ( SMALL )'],
        ];

        DB::table('machines')->insert($machine);
    }
}
