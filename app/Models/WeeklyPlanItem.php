<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WeeklyPlanItem extends Model
{
    protected $fillable = [
        'weekly_supervisor_plan_id',
        'date',
        'location',
        'title',
        'objectives',
        'activities',
        'notes',
        'status',
    ];

    public function weeklyPlan()
    {
        return $this->belongsTo(WeeklySupervisorPlan::class, 'weekly_supervisor_plan_id');
    }

    public function visitReport() : HasOne
    {
        return $this->hasOne(VisitReport::class);
    }
}
