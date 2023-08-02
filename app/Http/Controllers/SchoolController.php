<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::latest()->get();
        return view('admin.schools', ['data' => $schools]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $school = School::find(Auth::guard('school')->id());
        return view('school.settings', ['data' => $school]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $school = new School;
        $school->name = $request->name;
        $school->email = $request->email;
        $school->created_at = now();
        $school->password = bcrypt('password');
        $school->save();
        return redirect('/admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        if ($school != null) {
            $school->name = $request->name;
            $school->email = $request->email;
            $school->update();
            return redirect('/admin');
        } else {
            return back()->withErrors('School acoount not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        if ($school != null) {
            $school->delete();
            return redirect('/admin');
        } else {
            return back()->withErrors('School acoount not found');
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'confirmPassword' => 'required|string'
        ]);

        $school = School::find(Auth::guard('school')->id());

        if ($request->password == $request->confirmPassword) {
            $school->password = bcrypt($request->password);
            $school->update();
            return redirect('/school/settings');
        } else {
            return redirect('/school/settings')->withErrors('Passwords not match');
        }
    }
}
