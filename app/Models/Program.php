<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'description',
        'province_id',
        'manager_id',
        'allow_self_registration',
        'status',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function manager()
    {
        return $this->belongsTo(Supervisor::class, 'manager_id');
    }

    public function registrations()
    {
        return $this->hasMany(ProgramRegistration::class);
    }

    public function nominations()
    {
        return $this->hasMany(ProgramNomination::class);
    }

    public function reports()
    {
        return $this->hasMany(ProgramReport::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'program_supervisors')
                    ->using(ProgramSupervisor::class)
                    ->withTimestamps();
    }
}
