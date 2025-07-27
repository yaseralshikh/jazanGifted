<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function giftedTeachers()
    {
        return $this->hasMany(GiftedTeacher::class);
    }
}
