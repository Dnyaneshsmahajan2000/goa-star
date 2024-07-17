<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemcategory=[
            ['name'=>'Furniture','description'=>'Demo']
        ];
        DB::table('item_categories')->insert($itemcategory);
    }
}
