<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLoginForm() {
        return view('LoginSystem.AdminLogin');
    }

    public function login(Request $request) {
        // Validate the incoming request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Get credentials from request
        $username = $request->input('username');
        $password = $request->input('password');

        // Check if credentials match
        if ($username === 'admin' && $password === 'admin') {
            // Store admin session
            Session::put('admin_logged_in', true);
            Session::put('admin_username', $username);

            // Redirect to admin dashboard
            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
        }

        // If credentials don't match, redirect back with error
        return back()->withErrors([
            'credentials' => 'Invalid username or password.',
        ])->withInput($request->only('username'));
    }

    public function dashboard() {
        // Check if admin is logged in
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('AdminDashboard.Dashboard');
    }

    public function logout() {
        // Clear admin session
        Session::forget('admin_logged_in');
        Session::forget('admin_username');

        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}