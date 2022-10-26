<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Contracts\Service\Attribute\Required;

class UserController extends Controller
{
    //show register form
    public function create() {
        return view('users.register');
    }

    public function store(Request $request) {
        $novi = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')], //unique email for a users table
            'password' => 'required|confirmed|min:6' //confirmed provjeri ovo polje sa poljem sa istim imenom i dodanim _confirmation, zato u register view imamo password_confirmation kao name
        ]);

        //Hash password, bcrypt
        $novi['password'] = bcrypt($novi['password']);

        //ovaj creation ce odma loginat i creatat session

        //creata usera
        $user = User::create($novi);
        //login
        auth()->login($user); //auth helper i login sa passanim userom koji je upravo napravljen

        return redirect('/')->with('message', 'User created and logged in!111!!!1!!');
    }

    public function logout(Request $request) {
        auth()->logout(); //remove authentication info from user session so other requests arent authenticated
        //also we should invalidate session
        //and regenerate csrf token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been loged out!');
    }

    public function login() {
        return view('users.login');
    }

    public function authenticate(Request $request) {
        $novi = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($novi)) {
            $request->session()->regenerate();
            //ako je uspio login regenaratamo session

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials BAJO'])
        ->onlyInput('email');

    }
}
