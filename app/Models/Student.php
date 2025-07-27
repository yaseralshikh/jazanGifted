<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'birth_date',
        'school_id',
        'user_id',
        'talent_score_1',
        'talent_score_2',
        'talent_score_3',
        'year__score_1',
        'year__score_2',
        'year__score_3',
        'talent_type',
        'note',
    ];

    // الطالب مرتبط بالمستخدم الأساسي
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // المدرسة التي ينتمي لها الطالب
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // سجل أكاديمي حسب السنوات
    public function academicRecords()
    {
        return $this->hasMany(StudentAcademicRecord::class);
    }

    // تسجيل في برامج
    public function programRegistrations()
    {
        return $this->hasMany(ProgramRegistration::class);
    }

    // ترشيحات البرامج
    public function programNominations()
    {
        return $this->hasMany(ProgramNomination::class);
    }
}
