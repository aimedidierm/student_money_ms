<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Guardian;
use App\Models\Limit;
use App\Models\Order;
use App\Models\Student;
use App\Models\Transaction;
use App\Services\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::latest()->get();
        $transactions->load('students', 'canteens', 'guardians', 'schools');
        return view('admin.transactions', ['data' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transactions = Transaction::latest()->where('school_id', Auth::guard('school')->id())->get();
        $transactions->load('students', 'canteens', 'guardians', 'schools');
        return view('school.transactions', ['data' => $transactions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function canteenList()
    {
        $transactions = Transaction::latest()->where('canteen_id', Auth::guard('canteen')->id())->get();
        $transactions->load('students');
        return view('canteen.transactions', ['data' => $transactions]);
    }

    public function canteenPurchaseView(Request $request)
    {
        $request->validate([
            'regNumber' => 'required|string',
            'amount' => 'required|numeric',
            'password' => 'required|string',
            'comment' => 'required|string'
        ]);

        $student = Student::where('regNumber', $request->regNumber)->first();
        if ($student != null) {

            $passwordMatch = Hash::check($request->password, $student->password);
            if ($passwordMatch) {
                $guardian = Guardian::where('student_id', $student->id)->first();
                if ($guardian != null) {
                    if ($request->amount <= $student->balance) {
                        $limit = Limit::where('student_id', $student->id)->first();
                        $now = Carbon::now();
                        $startOfDay = $now->copy()->startOfDay();
                        $endOfDay = $now->copy()->endOfDay();
                        $total = Transaction::whereBetween('created_at', [$startOfDay, $endOfDay])
                            ->where('student_id', $student->id)
                            ->where('guardian_id', null)
                            ->where('canteen_id', Auth::guard('canteen')->id())
                            ->sum('amount');
                        $total = $total + $request->amount;
                        if ($total <= $limit->amount) {
                            $newBalance = $student->balance - $request->amount;
                            $studentModel = Student::find($student->id);
                            $studentModel->balance = $newBalance;
                            $studentModel->update();
                            $canteenModel = Canteen::find(Auth::id());
                            $canteenModel->balance = Auth::guard('canteen')->user()->balance + $request->amount;
                            $canteenModel->update();
                            $transaction = new Transaction;
                            $transaction->amount = $request->amount;
                            $transaction->status = 'debit';
                            $transaction->student_id = $student->id;
                            $transaction->canteen_id = Auth::guard('canteen')->id();
                            $transaction->school_id = Auth::guard('canteen')->user()->school_id;
                            $transaction->created_at = now();
                            $transaction->updated_at = null;
                            $transaction->save();
                            $order = new Order;
                            $order->comment = $request->comment;
                            $order->amount = $request->amount;
                            $order->student_id = $student->id;
                            $order->guardian_id = $guardian->id;
                            $order->created_at = now();
                            $order->save();

                            $message = "Dear parent " . $guardian->name . " your student " . $student->name . " had payed for " . $request->comment . " by total amount of " . $request->amount . "Rwf thank you.";
                            $sms = new Sms();
                            $sms->recipients([$guardian->phone])
                                ->message($message)
                                ->sender(env('SMS_SENDERID'))
                                ->username(env('SMS_USERNAME'))
                                ->password(env('SMS_PASSWORD'))
                                ->apiUrl("www.intouchsms.co.rw/api/sendsms/.json")
                                ->callBackUrl("");
                            $sms->send();
                            return redirect('/canteen');
                        } else {
                            return redirect('/canteen')->withErrors('You exceed daily limit');
                        }
                    } else {
                        return redirect('/canteen')->withErrors('Insuficient balance');
                    }
                } else {
                    return redirect('/canteen')->withErrors('You are not yet connected to any parent');
                }
            } else {
                return redirect('/canteen')->withErrors('Password not correct');
            }
        } else {
            return redirect('/canteen')->withErrors('Student not found');
        }
    }
}
