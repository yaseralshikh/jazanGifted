<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAcademicRecord extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'grade',
        'stage',
        'talent_score',
        'talent_type',
        'promoted',
        'note',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
