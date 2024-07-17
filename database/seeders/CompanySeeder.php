<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company=[
            ['company_name'=>'KJ Plast','mobile'=>'9876543210','email'=>'kjplast@gmail.com','address'=>'Jalgaon','city'=>'Jalgaon','state'=>'Maharashtra','pincode'=>'425001','fy_start_date'=>'2024-04-01','fy_end_date'=>'2025-03-31'],
          
          
        ];
        DB::table('companies')->insert($company);
    }
}
