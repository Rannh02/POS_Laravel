<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLoginForm() {
        return view('LoginSystem.AdminLogin');
    }

    public function login(Request $request) {
        // Add your authentication logic here
        return 'Admin login submitted!';
    }
}

