<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitReport extends Model
{
    protected $fillable = [
        'weekly_plan_item_id',
        'visited_at',
        'summary',
        'recommendations',
        'status',
    ];

    public function weeklyPlan()
    {
        return $this->belongsTo(WeeklySupervisorPlan::class, 'weekly_supervisor_plan_id');
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
