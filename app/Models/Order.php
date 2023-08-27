<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function guardians()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }
}
