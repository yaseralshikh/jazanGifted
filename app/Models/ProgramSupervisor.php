<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProgramSupervisor extends Pivot
{
    protected $table = 'program_supervisors';

    protected $fillable = [
        'program_id',
        'supervisor_id',
        'is_lead',
        'assigned_at',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
