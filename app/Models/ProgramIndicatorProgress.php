<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramIndicatorProgress extends Model
{
    protected $fillable = [
        'program_indicator_id',
        'supervisor_id',
        'achieved_value',
        'progress_date',
        'note',
        'is_completed',
    ];

    public function programIndicator()
    {
        return $this->belongsTo(ProgramIndicator::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
