<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register',[
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        //$validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        //$request->session()->flash('success', 'Registration successfull! Please login!');

        return redirect('/login')->with('success', 'Registration successfull! Please login!');
    }
}
