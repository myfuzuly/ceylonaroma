<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (session('admin_logged_in')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $adminEmail    = config('app.admin_email', env('ADMIN_EMAIL', 'admin@ceylonaroma.com'));
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@2024');

        // Also allow DB users
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            session(['admin_logged_in' => true, 'admin_name' => $user->name, 'admin_email' => $user->email]);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, '.$user->name.'!');
        }

        // Fallback env credentials
        if ($request->email === $adminEmail && $request->password === $adminPassword) {
            session(['admin_logged_in' => true, 'admin_name' => 'Administrator', 'admin_email' => $adminEmail]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_logged_in','admin_name','admin_email']);
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
