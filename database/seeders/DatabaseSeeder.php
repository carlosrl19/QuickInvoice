<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ClientsSeeder::class);
        $this->call(SellerSeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(FiscalFolioSeeder::class);
    }
}
