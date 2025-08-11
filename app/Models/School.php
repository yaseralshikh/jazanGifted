<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'province_id',
        'educational_stage',
        'educational_type',
        'educational_gender',
        'ministry_code',
        'school_manager_user_id',
        'status',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function managerAssignment()
    {
        return $this->hasOne(SchoolManager::class);
    }

    public function managerUser()
    {
        return $this->hasOneThrough(
            User::class,
            SchoolManager::class,
            'school_id', // FK in school_managers
            'id',        // PK in users
            'id',        // PK in schools
            'user_id'    // FK in school_managers
        );
    }

    // اختياري: اسم المدير مباشرة
    public function getManagerNameAttribute(): ?string
    {
        return $this->managerAssignment?->user?->name;
    }

    public function giftedTeachers()
    {
        return $this->hasMany(GiftedTeacher::class);
    }

    // إن أردت الوصول السريع لكل «يوزرات» المعلمين
    public function giftedTeacherUsers()
    {
        return $this->hasManyThrough(
            User::class,
            GiftedTeacher::class,
            'school_id', // FK على gifted_teachers يشير إلى schools.id
            'id',        // عمود الربط على users
            'id',        // مفتاح schools
            'user_id'    // FK على gifted_teachers يشير إلى users.id
        );
    }

    /** مرشّحات حسب النوع */
    public function dedicatedGiftedTeacher()   // المفرّغ
    {
        return $this->hasOne(GiftedTeacher::class)
                    ->where('teacher_type', 'dedicated');
    }

    public function coordinatorGiftedTeacher() // المنسّق
    {
        return $this->hasOne(GiftedTeacher::class)
                    ->where('teacher_type', 'coordinator');
    }

    public function teachingGiftedTeachers()   // المعلّم الممارس (قد يكونون أكثر من واحد)
    {
        return $this->hasMany(GiftedTeacher::class)
                    ->where('teacher_type', 'teaching');
    }

    /** اختيار «المعتمد» لعرض الاسم: المفرّغ أولاً ثم المنسق */
    public function getMainGiftedTeacherAttribute(): ?GiftedTeacher
    {
        return $this->giftedTeachers->firstWhere('teacher_type', 'dedicated')
            ?? $this->giftedTeachers->firstWhere('teacher_type', 'coordinator');
    }

    public function getMainGiftedTeacherNameAttribute(): ?string
    {
        return $this->mainGiftedTeacher?->user?->name;
    }

    public function visitReports()
    {
        return $this->hasMany(VisitReport::class);
    }    
}
