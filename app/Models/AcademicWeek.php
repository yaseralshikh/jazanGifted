<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicWeek extends Model
{
    protected $fillable = [
        'label',
        'week_number',
        'start_date',
        'end_date',
        'status',
        'academic_year_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
