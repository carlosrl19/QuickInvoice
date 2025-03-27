<?php

namespace Database\Seeders;

use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Services::create([
            'service_name' => 'Servicios Informáticos - Soporte I.T',
            'service_nomenclature' => 'servic',
            'service_type' => '1',
            'service_description' => null,
            'created_at' => Carbon::now()->setTimezone('America/Costa_Rica'),
            'updated_at' => Carbon::now()->setTimezone('America/Costa_Rica')
        ]);

        Services::create([
            'service_name' => 'Servicios Informáticos - Soporte I.T Exonerado',
            'service_nomenclature' => 'servic',
            'service_type' => '0',
            'service_description' => null,
            'created_at' => Carbon::now()->setTimezone('America/Costa_Rica'),
            'updated_at' => Carbon::now()->setTimezone('America/Costa_Rica')
        ]);
    }
}
