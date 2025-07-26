<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftedTeacher extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'specialization_id',
        'academic_qualification',
        'experience_years',
        'assigned_at',
        'status',
        'notes',
    ];
}
