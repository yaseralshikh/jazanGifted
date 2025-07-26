<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'description',
        'province_id',
        'manager_id',
        'allow_self_registration',
        'status',
    ];
}
