<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeeklySupervisorPlan extends Model
{
    protected $fillable =[
        'supervisor_id',
        'week_start',
        'week_end',
    ];

    public function supervisor() : BelongsTo
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function items() : HasMany
    {
        return $this->hasMany(WeeklyPlanItem::class);
    }

    public function visitReports()
    {
        return $this->hasMany(VisitReport::class);
    }
}
