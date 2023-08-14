<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Guardian;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerSchools()
    {
        $schools = School::latest()->get();
        return view('register', ['data' => $schools]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $admin = User::where('email', $email)->first();
        $school = School::where('email', $email)->first();
        $canteen = Canteen::where('email', $email)->first();
        $guardian = Guardian::where('email', $email)->first();
        if ($admin != null) {
            $passwordMatch = Hash::check($password, $admin->password);
            if ($passwordMatch) {
                Auth::login($admin);
                return redirect("/admin/canteen");
            } else {
                return redirect("/")->withErrors(['msg' => 'Incorect password']);
            }
        } elseif ($school != null) {
            $passwordMatch = Hash::check($password, $school->password);
            if ($passwordMatch) {
                Auth::guard("school")->login($school);
                return redirect("/school");
            } else {
                return redirect("/")->withErrors(['msg' => 'Incorect password']);
            }
        } elseif ($canteen != null) {
            $passwordMatch = Hash::check($password, $canteen->password);
            if ($passwordMatch) {
                Auth::guard("canteen")->login($canteen);
                return redirect("/canteen");
            } else {
                return redirect("/")->withErrors(['msg' => 'Incorect password']);
            }
        } elseif ($guardian != null) {
            $passwordMatch = Hash::check($password, $guardian->password);
            if ($passwordMatch) {
                Auth::guard("parent")->login($guardian);
                return redirect("/parent");
            } else {
                return redirect("/")->withErrors(['msg' => 'Incorect password']);
            }
        } else {
            return redirect('/')->withErrors(['msg' => 'Incorect email and password']);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect(route("login"));
        } else if (Auth::guard('school')->check()) {
            Auth::guard("school")->logout();
            return redirect(route("login"));
        } else if (Auth::guard('canteen')->check()) {
            Auth::guard("canteen")->logout();
            return redirect(route("login"));
        } else if (Auth::guard('parent')->check()) {
            Auth::guard("parent")->logout();
            return redirect(route("login"));
        } else {
            return back();
        }
    }
}
