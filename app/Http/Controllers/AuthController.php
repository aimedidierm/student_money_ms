<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerSchools()
    {
        $schools = School::latest()->get();
        return view('register', ['data' => $schools]);
    }
}
