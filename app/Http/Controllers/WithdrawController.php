<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Paypack\Paypack;

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
        $withdraws = Withdraw::latest()->where('canteen_id', Auth::guard('canteen')->id())->get();
        $withdraws->load('students');
        return view('canteen.withdraw', ['data' => $withdraws]);
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

    public function canteenWithdraw(Request $request)
    {
        $request->validate(
            [
                'amount' => 'required|numeric',
                'phone' => 'required|numeric|regex:/^07\d{8}$/',
            ],
            $messages = [
                'phone.regex' => 'The phone number must start with "07" and be 10 digits long.'
            ]
        );
        $canteen = Canteen::find(Auth::guard('canteen')->id());
        if ($request->amount <= $canteen->balance) {
            $newBalance = $canteen->balance - $request->amount;
            $canteen->balance = $newBalance;
            $canteen->update();
            $withdraw = new Withdraw;
            $withdraw->amount = $request->amount;
            $withdraw->phone = $request->phone;
            $withdraw->canteen_id = $canteen->id;
            $withdraw->school_id = Auth::guard('canteen')->user()->school_id;
            $withdraw->created_at = now();
            $withdraw->save();
            $transaction = new Transaction;
            $transaction->amount = $request->amount;
            $transaction->status = 'credit';
            $transaction->canteen_id = $canteen->id;
            $transaction->school_id = Auth::guard('canteen')->user()->school_id;
            $transaction->created_at = now();
            $transaction->save();
            $paypackInstance = $this->paypackConfig()->Cashout([
                "amount" => $request->amount,
                "phone" => $request->phone,
            ]);
            return redirect('/canteen/withdraw');
        } else {
            return redirect('/canteen/withdraw')->withErrors('Insuficient balance');
        }
    }

    public function paypackConfig()
    {
        $paypack = new Paypack();

        $paypack->config([
            'client_id' => env('PAYPACK_CLIENT_ID'),
            'client_secret' => env('PAYPACK_CLIENT_SECRET'),
        ]);

        return $paypack;
    }
}
