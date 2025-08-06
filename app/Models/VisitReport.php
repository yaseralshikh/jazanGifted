<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitReport extends Model
{
    protected $fillable = [
        'academic_year_id',
        'supervisor_id',
        'school_id',
        'weekly_plan_item_id',
        'visited_at',
        'summary',
        'recommendations',
        'status',
    ];

    public function weeklyPlan()
    {
        return $this->belongsTo(WeeklyPlanItem::class, 'weekly_plan_item_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
