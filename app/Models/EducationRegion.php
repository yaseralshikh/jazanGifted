<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationRegion extends Model
{
    protected $fillable =[
        'name',
        'status',
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'education_region_user')->withTimestamps();
    }
}
