<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramReport extends Model
{
    protected $fillable = [
        'program_id',
        'report_date',
        'summary',
        'attendees_count',
        'achievements',
        'evaluation',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
