<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Canteen extends Authenticatable
{
    use HasFactory;

    public function schools()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
