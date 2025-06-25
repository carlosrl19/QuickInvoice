<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SellerSeeder::class);
        $this->call(FiscalFolioSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(RolePermissionUserSeeder::class);
    }
}
