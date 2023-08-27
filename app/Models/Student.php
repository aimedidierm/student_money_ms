<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function schools()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'student_id');
    }

    public function parent()
    {
        return $this->hasOne(Guardian::class, 'student_id');
    }
}
