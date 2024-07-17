<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CompanySeeder::class);
        $this->call(GodownSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(LedgerSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(ItemCategorySeeder::class);
        $this->call(ItemGroupSeeder::class);
        $this->call(ItemSeeder::class);
        /*        $this->call(ItemBomSeeder::class);
     */
        $this->call(MachineSeeder::class);
        $this->call(PaymentReceiptSeeder::class);

        $this->call(UserRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StocksSeeder::class);
        $this->call(TransactionsSeeder::class);
        $this->call(ModeSeeder::class);
    }
}
