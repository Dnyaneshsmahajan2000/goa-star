<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            ['group_name' => 'Income', 'parent_id' => 0, 'level' => 1],
            ['group_name' => 'Expenses', 'parent_id' => 0, 'level' => 1],
            ['group_name' => 'Assets', 'parent_id' => 0, 'level' => 1],
            ['group_name' => 'Liabilities', 'parent_id' => 0, 'level' => 1],
            ['group_name' => 'Current Assets', 'parent_id' => 3, 'level' => 2],
            ['group_name' => 'Fixed Assets', 'parent_id' => 3, 'level' => 2],
            ['group_name' => 'Investments', 'parent_id' => 3, 'level' => 2],
            ['group_name' => 'Misc. Expenses (Assets)', 'parent_id' => 3, 'level' => 2],
            ['group_name' => 'Bank Accounts', 'parent_id' => 5, 'level' => 3],
            ['group_name' => 'Branch / Divisions', 'parent_id' => 4, 'level' => 2],
            ['group_name' => 'Capital Account', 'parent_id' => 4, 'level' => 2],
            ['group_name' => 'Current Liabilities', 'parent_id' => 4, 'level' => 2],
            ['group_name' => 'Loans (Liability)', 'parent_id' => 4, 'level' => 2],
            ['group_name' => 'Suspense A/c', 'parent_id' => 4, 'level' => 2],
            ['group_name' => 'Profit & Loss A/c', 'parent_id' => 4, 'level' => 2],
            ['group_name' => 'Direct Expenses', 'parent_id' => 2, 'level' => 2],
            ['group_name' => 'Indirect Expenses', 'parent_id' => 2, 'level' => 2],
            ['group_name' => 'Purchase Accounts', 'parent_id' => 2, 'level' => 2],
            ['group_name' => 'Direct Incomes', 'parent_id' => 1, 'level' => 2],
            ['group_name' => 'Indirect Incomes', 'parent_id' => 1, 'level' => 2],
            ['group_name' => 'Sales Accounts', 'parent_id' => 1, 'level' => 2],
            ['group_name' => 'Cash-in-hand', 'parent_id' => 5, 'level' => 3],
            ['group_name' => 'Loans & Advances (Assets)', 'parent_id' => 5, 'level' => 3],
            ['group_name' => 'Sundry Debtors (Customers)', 'parent_id' => 5, 'level' => 3],
            ['group_name' => 'Duties & Taxes', 'parent_id' => 12, 'level' => 3],
            ['group_name' => 'Sundry Creditors (Suppliers)', 'parent_id' => 12, 'level' => 3],
            ['group_name' => 'Secured Loans', 'parent_id' => 13, 'level' => 3],
            ['group_name' => 'Unsecured Loans', 'parent_id' => 13, 'level' => 3],
            ['group_name' => 'Salary Payable', 'parent_id' => 12, 'level' => 3],
            ['group_name' => 'ABASAHEB REGION', 'parent_id' => 42, 'level' => 5],
            ['group_name' => 'AURANGABAD WALUJ SALE', 'parent_id' => 41, 'level' => 4],
            ['group_name' => 'STAFF ADVANCE ACCOUNT', 'parent_id' => 5, 'level' => 3],
            ['group_name' => 'FERIWALA', 'parent_id' => 24, 'level' => 4]


        ];

        DB::table('groups')->insert($groups);
    }
}
