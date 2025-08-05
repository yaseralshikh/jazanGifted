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

}
