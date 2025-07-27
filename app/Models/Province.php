<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['name', 'education_region_id'];

    public function educationRegion()
    {
        return $this->belongsTo(EducationRegion::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'province_supervisor')->withTimestamps();
    }
}
