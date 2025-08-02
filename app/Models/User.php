<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laratrust\Contracts\LaratrustUser;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements LaratrustUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'national_id',
        'gender',
        'education_region_id', // ربط المستخدم بالمنطقة التعليمية
        'password',
        'user_type', // نوع المستخدم (طالب، معلم، مدير مدرسة، مشرف)
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // علاقات المستخدم

    public function provinces()
    {
        return $this->belongsToMany(Province::class);
    }

    public function educationRegion()
    {
        return $this->belongsTo(EducationRegion::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function supervisor()
    {
        return $this->hasOne(Supervisor::class);
    }

    public function giftedTeacher()
    {
        return $this->hasOne(GiftedTeacher::class);
    }

    public function managerOfSchool()
    {
        return $this->hasOne(School::class, 'school_manager_user_id');
    }

    public function teacherOfSchool()
    {
        return $this->hasOne(School::class, 'gifted_teacher_user_id');
    }

    public function nominationsMade()
    {
        return $this->hasMany(ProgramNomination::class, 'nominated_by');
    }

    public function responsibilities()
    {
        return $this->belongsToMany(Responsibility::class)->withTimestamps();
    }

    public function programRegistrations()
    {
        return $this->hasMany(ProgramRegistration::class);
    }
}
