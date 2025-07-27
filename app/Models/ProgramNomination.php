<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramNomination extends Model
{
    protected $fillable = [
        'program_id',
        'student_id',
        'nominated_by',
        'status',
        'note',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function nominator()
    {
        return $this->belongsTo(User::class, 'nominated_by');
    }
}
