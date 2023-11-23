<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
use Session;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {   
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function authenticate(Request $request)
    {
         $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/todos');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'confirm-password' => 'required|same:password'
        ]);
        $data = $request->except('confirm-password', 'password');
        $data['password'] = Hash::make($request->password);

        User::create($data);
        return redirect('/login');
    }

    public function logout()
    {   Session::flush();
        Auth::logout();
        return Redirect('login');
        // Auth::logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return redirect('/login');
    }
}
