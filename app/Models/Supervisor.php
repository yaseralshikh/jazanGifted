<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supervisor extends Model
{
    protected $fillable = [
        'user_id',
        'administrative_role_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function administrativeRole()
    {
        return $this->belongsTo(AdministrativeRole::class);
    }

    public function provinces()
    {
        // العلاقة pivot من جدول province_supervisor
        return $this->belongsToMany(Province::class, 'province_supervisor')->withTimestamps();
    }

    public function programs()
    {
        // العلاقة pivot من جدول program_supervisors
        return $this->belongsToMany(Program::class, 'program_supervisors')->withTimestamps();
    }

    public function plans()
    {
        return $this->hasMany(WeeklySupervisorPlan::class);
    }

    public function visitReports()
    {
        return $this->hasManyThrough(
            VisitReport::class,
            WeeklySupervisorPlan::class,
            'supervisor_id',
            'weekly_supervisor_plan_id'
        );
    }
}
