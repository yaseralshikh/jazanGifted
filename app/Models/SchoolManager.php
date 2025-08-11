<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolManager extends Model
{
    protected $fillable = ['user_id','school_id','assigned_at','status','notes'];
    protected $casts = ['assigned_at' => 'datetime'];

    public function user(){ return $this->belongsTo(User::class); }
    public function school(){ return $this->belongsTo(School::class); }
}
