<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanteenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $canteens = Canteen::latest()->get();
        $canteens->load('schools');
        return view('admin.canteen', ['data' => $canteens]);
    }

    public function schoolList()
    {
        $canteens = Canteen::latest()->where('school_id', Auth::guard('school')->id())->get();
        $canteens->load('schools');
        return view('school.canteen', ['data' => $canteens]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $canteen = Canteen::find(Auth::guard('canteen')->id());
        return view('canteen.settings', ['data' => $canteen]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', new \App\Rules\UniqueEmailAcrossTables],
        ]);

        $canteen = new Canteen;
        $canteen->name = $request->name;
        $canteen->email = $request->email;
        $canteen->password = bcrypt('password');
        $canteen->school_id = Auth::guard('school')->id();
        $canteen->created_at = now();
        $canteen->save();
        return redirect('/school/canteen');
    }

    /**
     * Display the specified resource.
     */
    public function show(Canteen $canteen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Canteen $canteen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'id' => 'required|numeric',
        ]);
        $canteen = Canteen::find($request->id);
        if ($canteen != null) {
            $canteen->name = $request->name;
            $canteen->email = $request->email;
            $canteen->update();
            return redirect('/school/canteen');
        } else {
            return back()->withErrors('Canteen not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Canteen $canteen)
    {
        if ($canteen != null) {
            $canteen->delete();
            return redirect('/school/canteen');
        } else {
            return back()->withErrors('Canteen not found');
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'confirmPassword' => 'required|string'
        ]);

        $canteen = Canteen::find(Auth::guard('canteen')->id());

        if ($request->password == $request->confirmPassword) {
            $canteen->password = bcrypt($request->password);
            $canteen->update();
            return redirect('/canteen/settings');
        } else {
            return redirect('/canteen/settings')->withErrors('Passwords not match');
        }
    }
}
