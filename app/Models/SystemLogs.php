<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLogs extends Model
{
    protected $fillable = [
        'module_log',
        'log_description'
    ];
}
