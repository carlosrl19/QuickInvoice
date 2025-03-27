<?php

namespace Database\Seeders;

use App\Models\Clients;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 clients
        Clients::factory()
            ->count(50)
            ->create();
    }
}
