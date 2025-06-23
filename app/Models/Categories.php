<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'category_name',
        'category_description',
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
