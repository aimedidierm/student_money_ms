<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guardian extends Authenticatable
{
    use HasFactory;

    public function students()
    {
        return $this->belongsTo(Student::class, 'school_id');
    }
}
