<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\School;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'school' => 'required|numeric',
            'phone' => 'required',
            'password' => 'required|string',
            'confirmPassword' => 'required|string'
        ]);

        if ($request->password == $request->confirmPassword) {
            $school = School::find($request->school);
            if ($school != null) {
                $guardian = new Guardian;
                $guardian->name = $request->name;
                $guardian->email = $request->email;
                $guardian->phone = $request->phone;
                $guardian->password = bcrypt($request->password);
                $guardian->school_id = $request->school;
                $guardian->student_id = null;
                $guardian->save();
                return redirect(route('login'));
            } else {
                return redirect('/register')->withErrors('School not found');
            }
        } else {
            return redirect('/register')->withErrors('Passwords not match');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guardian $guardian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guardian $guardian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guardian $guardian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian)
    {
        //
    }
}
