<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramRegistration extends Model
{
    protected $fillable = [
        'student_id',
        'program_id',
        'registered_at',
        'status',
        'evaluation',
        'certificate_url',
    ];
}
