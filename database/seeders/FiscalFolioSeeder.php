<?php

namespace Database\Seeders;

use App\Models\FiscalFolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiscalFolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FiscalFolio::create([
            'folio_authorized_range_start' => '000-001-01-00000000',
            'folio_authorized_range_end' => '000-001-01-00000999',
            'folio_total_invoices' => '999',
            'folio_total_invoices_available' => '999',
            'folio_authorized_emission_date' => '2025-10-22',
            'folio_validation_status' => 1,
            'folio_status' => 1,
        ]);
    }
}
