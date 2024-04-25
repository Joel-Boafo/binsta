<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('users.login');
    }

    public function register(): View
    {
        return view('users.register');
    }

    public function loginPost(LoginUserRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('status', 'Logged in successfully');
        }

        return redirect()->route('users.login')->with('error', 'Invalid credentials');
    }

    public function registerPost(RegisterUserRequest $request): RedirectResponse
    {
        $existingUser = User::where('username', $request->username)->orWhere('email', $request->email)->first();

        if ($existingUser) {
            return redirect()->route('users.register')->with('error', 'User already exists');
        }

        if ($request->password !== $request->confirm_password) {
            return redirect()->route('users.register')->with('error', 'Passwords do not match');
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return redirect()->route('users.register')->with('error', 'Something went wrong');
        }

        return redirect()->route('users.login')->with('status', 'Registered successfully');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('users.login')->with('status', 'Logged out successfully');
    }
}