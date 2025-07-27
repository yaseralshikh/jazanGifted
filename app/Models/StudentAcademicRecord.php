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

    public const GRADES = [
        'KG1', 'KG2',
        'G1', 'G2', 'G3', 'G4', 'G5', 'G6',
        'G7', 'G8', 'G9',
        'G10', 'G11', 'G12'
    ];

    public const STAGES = ['kindergarten', 'primary', 'middle', 'secondary'];

    public const TALENT_TYPES = ['promising', 'talented', 'exceptionally_talented'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
