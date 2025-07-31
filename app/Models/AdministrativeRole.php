<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeRole extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }
}
