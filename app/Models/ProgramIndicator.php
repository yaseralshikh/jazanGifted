<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramIndicator extends Model
{
    protected $fillable = [
        'program_id',
        'title',
        'type',
        'target_value',
        'is_required',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function progress()
    {
        return $this->hasMany(ProgramIndicatorProgress::class);
    }
}
