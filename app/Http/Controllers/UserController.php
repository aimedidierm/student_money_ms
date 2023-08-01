<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = User::find(Auth::id());
        return view('admin.settings', ['data' => $admin]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'password' => 'required|string',
            'confirmPassword' => 'required|string'
        ]);
        if ($request->password == $request->confirmPassword) {
            $admin = User::find($id);
            if ($admin != null) {
                $admin->password = $request->password;
                $admin->update();
                return redirect('/admin/settings');
            } else {
                return back()->withErrors('Admin account not match');
            }
        } else {
            return back()->withErrors('Passwords not match');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
