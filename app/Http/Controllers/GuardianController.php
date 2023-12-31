<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = Guardian::latest()->get();
        $parents->load('students.schools');
        return view('admin.parents', ['data' => $parents]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Guardian::latest()->where('school_id', Auth::guard('school')->id())->get();
        $parents->load('students');
        $students = Student::where('school_id', Auth::guard('school')->id())->get();
        return view('school.parents', ['data' => $parents, 'students' => $students]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => ['required', 'email', new \App\Rules\UniqueEmailAcrossTables],
                'school' => 'required|numeric',
                'password' => 'required|string',
                'confirmPassword' => 'required|string',
                'phone' => 'required|numeric|regex:/^07\d{8}$/',
            ],
            $messages = [
                'phone.regex' => 'The phone number must start with "07" and be 10 digits long.',
            ]
        );

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
    public function update(Request $request)
    {
        $request->validate([
            'parent' => 'required|numeric',
            'student' => 'required|numeric',
        ]);

        $parent = Guardian::find($request->parent);
        $student = Student::find($request->student);
        if (($parent && $student) != null) {
            $parent->student_id = $request->student;
            $parent->update();
            return redirect('/school/parents');
        } else {
            return redirect('/school/parents')->withErrors('Student or parent not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian)
    {
        $guardian->delete();
        return redirect('school/parents');
    }

    public function parentShow()
    {
        $guardian = Guardian::find(Auth::guard('parent')->id());
        return view('parent.settings', ['data' => $guardian]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'confirmPassword' => 'required|string'
        ]);

        $parent = Guardian::find(Auth::guard('parent')->id());

        if ($request->password == $request->confirmPassword) {
            $parent->password = bcrypt($request->password);
            $parent->update();
            return redirect('/parent/settings');
        } else {
            return redirect('/parent/settings')->withErrors('Passwords not match');
        }
    }
}
