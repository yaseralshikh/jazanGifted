<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'birth_date',
        'school_id',
        'user_id',
        'talent_score_1',
        'talent_score_2',
        'talent_score_3',
        'year__score_1',
        'year__score_2',
        'year__score_3',
        'talent_type',
        'note',
    ];
}
