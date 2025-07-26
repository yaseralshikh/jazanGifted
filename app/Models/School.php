<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'province_id',
        'educational_stage',
        'ministry_code',
        'principal_user_id',
        'gifted_teacher_user_id',
        'gender',
        'status',
    ];
}
