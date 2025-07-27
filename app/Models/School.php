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

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function principal()
    {
        return $this->belongsTo(User::class, 'principal_user_id');
    }

    public function giftedTeacher()
    {
        return $this->belongsTo(User::class, 'gifted_teacher_user_id');
    }

    public function visitReports()
    {
        return $this->hasMany(VisitReport::class);
    }    
}
