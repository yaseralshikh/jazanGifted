<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftedTeacher extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'specialization_id',
        'academic_qualification',
        'experience_years',
        'assigned_at',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
