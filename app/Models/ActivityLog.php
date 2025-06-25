<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    protected $fillable = [
        "log_name",
        "description",
        "subject_type",
        "event",
        "causer_id",
        "properties",
        "batch_uuid",
        "created_at",
        "updated_at"
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
