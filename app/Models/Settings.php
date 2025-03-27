<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'logo_company',
        'system_icon',
        'show_system_name',
        'company_name',
        'company_cai',
        'company_rtn',
        'company_phone',
        'company_email',
        'company_address',
        'company_short_address',
    ];
}
