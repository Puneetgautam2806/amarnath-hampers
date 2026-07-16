<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 1,
        ], (bool) $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return redirect('backoffice/login')->withErrors([
            'email' => 'Invalid credentials or your account is inactive.',
        ]);
    }

    public function dashboardPage()
    {
        return view('backoffice.dashboard');
    }

    public function create()
    {
        return view('backoffice.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'usertype' => 'required|in:admin,manager,staff,developer',
            'status' => 'required|integer|in:1,2',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'usertype' => $validated['usertype'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('manageUser')->with('success', 'User created successfully.');
    }

    public function manage()
    {
        $users = User::query()->orderBy('id', 'desc')->get();

        return view('backoffice.users.manage', ['users' => $users]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
