<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function loginView() {
        return view('auth.login');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->flash('status', 'Welcome!');
            return redirect()->route('home');
        }

        $request->session()->flash('status', 'Invalid email address and / or password.');
        return redirect()->route('login');
    }

    public function registerView() {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:users|string|max:255|min:5',
            'email' => 'required|unique:users|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        Auth::login($user);

        $request->session()->flash('status', 'Welcome!');
        return redirect()->route('home');
    }

    public function profile(Request $request) {
        $user = $request->user();
        $tests = Test::all()->where('author', $user->name);
        return view('profile', ['user'=>$user, 'tests'=>$tests]);
    }

}