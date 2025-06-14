<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request as req;
use Illuminate\Support\Facades\Auth;


class LoginUser extends Controller
{
    // function show login page
    public function show(){
        return view('login',['doc' => 'Login', 'css' => 'login']);
    }
    
    // function login verfivikasi
    public function login(req $req)
    {
        $credentials = $req->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        
        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
         if (Auth::user()->is_admin) {
        return redirect('/admin')->with([
            'message' => 'Login Success with admin role welcome back '.Auth::user()->username.'',
            'status'=>'success',
        ]);
         }
         return redirect('/dashboard')->with([
            'status'=>'success',
            'message' => 'Login Success with user role welcome back '.Auth::user()->username.'',
        ]);
        }

        return back()->with([
            'message' => 'The provided credentials do not match our records.',
            'status'=>'danger',
        ]);
    }
    // function untuk logout
public function logout(req $req){
    // Store current user info before logging out
    $user = Auth::user();
    $username = $user ? $user->username : 'Guest';
    
    // Invalidate session and regenerate token
    $req->session()->invalidate();
    $req->session()->regenerateToken();
    
    
    return redirect('/')->with([
        'status' => 'success',
        'message' => "Goodbye, $username. You have been successfully logged out."
    ]);
}
}
