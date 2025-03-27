<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{

    public function run(): void
    {
        Settings::create([
            'logo_company' => 'default_icon.png',
            'system_icon' => 'default_icon.png',
            'show_system_name' => 1,
            'company_name' => 'Inversiones ROBENIOR',
            'company_cai' => '2513C0-E8BB43-D7BAE0-63BE03-090902-4C',
            'company_rtn' => '08011999032001',
            'company_phone' => '9799-2899',
            'company_email' => 'text@robenior.com',
            'company_address' => 'Bº RIO DE PIEDRAS, 22 AVE, 5 CALLE, SAN PEDRO SULA, CORTES, HONDURAS',
            'company_short_address' => 'SAN PEDRO SULA, HONDURAS',
        ]);
    }
}
