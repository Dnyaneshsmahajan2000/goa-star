<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_roles=[
            ['name'=>'Admin','can_login'=>'1'],
            ['name'=>'User','can_login'=>'1'],
            ['name'=>'Salesman','can_login'=>'1'],
            ['name'=>'Worker','can_login'=>'0'],
            
        ];
        DB::table('user_roles')->insert($user_roles);
    }
}
