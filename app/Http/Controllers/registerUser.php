<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class registerUser extends Controller
{
// functiopn show register page
public function show(){
    return view('register',['doc' => 'Register', 'css' => 'register']);

}

//   function tangkap username dan password
public function register(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string',
        'email' => 'required|email|unique:users,email'
    ]);

    $user = User::create([
        'username' => $validated['username'],
        'password' => bcrypt($validated['password']),
        'email' => $validated['email']
    ]);

    // Optionally, you can log the user in after registration
   auth()->login($user);
   return redirect('/dashboard')->with([
       'status' => 'success',
       'message' => 'Registration successful. Please login.'
   ]);



}
}
