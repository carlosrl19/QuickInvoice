<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_code',
        'client_document',
        'client_type',
        'client_phone1',

        // Not required data
        'client_phone2',
        'client_birthdate',
        'client_phone_home',
        'client_actual_job',
        'client_job_length',
        'client_phone_work',
        'client_last_job',
        'client_own_business',
        'client_email',
        'client_exonerated',
        'client_status',
        'client_address',
    ];

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loans::class, 'client_id');
    }

    public function pos()
    {
        return $this->hasMany(Pos::class, 'client_id');
    }
}
