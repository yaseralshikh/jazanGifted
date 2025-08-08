<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function studentRecords()
    {
        return $this->hasMany(StudentAcademicRecord::class);
    }

    public function visitReports()
    {
        return $this->hasMany(VisitReport::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
    public function academicWeeks()
    {
        return $this->hasMany(AcademicWeeks::class);
    }
}
