<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsibility extends Model
{
    protected $fillable = [
        'title',
        'code',
        'description',
        'active',
        'scope_type',
        'scope_id',
    ];
}
