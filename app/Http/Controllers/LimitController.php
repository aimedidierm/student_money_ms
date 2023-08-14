<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Limit;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Guardian::find(Auth::guard('parent')->id());
        $student->load('students');
        $amount = Limit::where('student_id', Auth::guard('parent')->user()->student_id)->first();
        return view('parent.amount', ['data' => $student, 'amount' => $amount]);
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
            'student' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);
        if ($request->password != null) {
            $student = Student::find($request->student);
            $student->password = bcrypt($request->password);
            $student->update();
        }
        $amount = Limit::where('student_id', Auth::guard('parent')->user()->student_id)->first();
        if ($amount == null) {
            $limit = new Limit;
            $limit->amount = $request->amount;
            $limit->student_id = $request->student;
            $limit->guardian_id = Auth::guard('parent')->id();
            $limit->save();
            return redirect('/parent/student');
        } else {
            $amount->amount = $request->amount;
            $amount->update();
            return redirect('/parent/student');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Limit $limit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Limit $limit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    private function update(Request $request, Limit $limit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Limit $limit)
    {
        //
    }
}
