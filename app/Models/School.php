<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'province_id',
        'educational_stage',
        'educational_type',
        'educational_gender',
        'ministry_code',
        'school_manager_user_id',
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

    public function schoolManager()
    {
        return $this->belongsTo(User::class, 'school_manager_user_id');
    }

    public function giftedTeachers()
    {
        return $this->hasMany(GiftedTeacher::class);
    }

    public function visitReports()
    {
        return $this->hasMany(VisitReport::class);
    }    
}
