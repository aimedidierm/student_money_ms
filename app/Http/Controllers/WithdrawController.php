<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transaction;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdraws = Withdraw::latest()->get();
        $withdraws->load('students');
        $students = Student::where('school_id', Auth::guard('school')->id())->get();
        return view('school.withdraw', ['data' => $withdraws, 'students' => $students]);
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
        $student = Student::find($request->student);
        if ($student != null) {
            if ($request->amount <= $student->balance) {
                $newBalance = $student->balance - $request->amount;
                $student->balance = $newBalance;
                $student->update();
                $withdraw = new Withdraw;
                $withdraw->amount = $request->amount;
                $withdraw->phone = null;
                $withdraw->student_id = $request->student;
                $withdraw->school_id = Auth::guard('school')->id();
                $withdraw->created_at = now();
                $withdraw->save();
                $transaction = new Transaction;
                $transaction->amount = $request->amount;
                $transaction->status = 'credit';
                $transaction->student_id = $request->student;
                $transaction->school_id = Auth::guard('school')->id();
                $transaction->created_at = now();
                $transaction->save();
                return redirect('/school/withdraw');
            } else {
                return redirect('/school/withdraw')->withErrors('Insuficient balance');
            }
        } else {
            return redirect('/school/withdraw')->withErrors('Student not  found');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }
}
