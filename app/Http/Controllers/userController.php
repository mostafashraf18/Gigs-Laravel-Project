<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use TijsVerkoyen\CssToInlineStyles\Css\Rule\Rule;

class userController extends Controller
{
    public function create() {
        return view('users.register');
    }

    //store
    public function store(Request $request) {
        $formFields = $request->validate([
            'name'=> ['required','min:3'],
            'email'=> ['required', 'email', ValidationRule::unique('users', 'email') ],
            'password'=> ['required', 'confirmed', 'min:6']

        ]);

        //hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //create user
        $user = User::create($formFields);


        //login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');

    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'you have been logged out!');
    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    // Authenticate User
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}