<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicWeeks extends Model
{
    protected $fillable = [
        'label',
        'week_number',
        'start_date',
        'end_date',
        'is_active',
        'academic_year_id',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
