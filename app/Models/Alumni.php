<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'graduation_year',
        'status',
        'company_name',
        'position'
    ];
}
