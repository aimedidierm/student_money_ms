<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Paypack\Paypack;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->get();
        $students->load('schools');
        return view('admin.student', ['data' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::latest()->where('school_id', Auth::guard('school')->id())->get();
        return view('school.students', ['data' => $students]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'regNumber' => 'required|string'
        ]);

        $student = new Student;
        $student->name = $request->name;
        $student->regNumber = $request->regNumber;
        $student->password = bcrypt('password');
        $student->school_id = Auth::guard('school')->id();
        $student->save();
        return redirect('/school');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string'
        ]);

        if ($student != null) {
            $student->name = $request->name;
            $student->regNumber = $request->email;
            $student->update();
            return redirect('/school');
        } else {
            return back()->withErrors('Student acoount not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if ($student != null) {
            $student->delete();
            return redirect('/school');
        } else {
            return back()->withErrors('Student not found');
        }
    }

    public function sendMoney()
    {
        $student = Guardian::find(Auth::guard('parent')->id());
        $student->load('students');
        return view('parent.send', ['data' => $student]);
    }

    public function sendMoneyToStudent(Request $request)
    {
        $request->validate(
            [
                'student' => 'required|numeric',
                'amount' => 'required|numeric',
                'phone' => 'required|numeric|regex:/^07\d{8}$/',
            ],
            $messages = [
                'phone.regex' => 'The phone number must start with "07" and be 10 digits long.'
            ]
        );

        $student = Student::find($request->student);

        if ($student != null) {

            $paypackInstance = $this->paypackConfig()->Cashin([
                "amount" => $request->amount,
                "phone" => $request->phone,
            ]);

            //Enter data in pending table

            $newBalance = $student->balance + $request->amount;
            $student->balance = $newBalance;
            $student->update();
            $transaction = new Transaction;
            $transaction->amount = $request->amount;
            $transaction->status = 'debit';
            $transaction->student_id = $request->student;
            $transaction->guardian_id = Auth::guard('parent')->id();
            $transaction->school_id = Auth::guard('parent')->user()->school_id;
            $transaction->created_at = now();
            $transaction->updated_at = null;
            $transaction->save();
            return redirect('/parent');
        } else {
            return back()->withErrors('Student not found');
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

    public function report()
    {
        $students = Student::latest()->get();
        $students->load('parent');
        // $pdf = Pdf::loadView('school.report', ['students' => $students]);

        // // return $pdf->download('list.pdf');
        // echo $pdf->output();
        $view = view('school.report', ['students' => $students]);
        // return $view;
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream();
    }
}
