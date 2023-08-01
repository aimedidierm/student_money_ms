<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function canteens()
    {
        return $this->belongsTo(Canteen::class, 'canteen_id');
    }

    public function guardians()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function schools()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
