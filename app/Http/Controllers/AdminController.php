<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
    
        // Total Orders
        $totalOrders = DB::table('orders')->count();
    
        // Total Income
        $totalIncome = DB::table('orders')->sum('TotalAmount') ?? 0;
    
        // Total Customers
        $totalCustomers = DB::table('orders')->distinct('Customer_id')->count('Customer_id');
    
        // Top 5 Best-Selling Products
        $topProducts = DB::table('order_items as oi')  // Changed from 'orderitem' to 'order_items'
            ->join('products as p', 'oi.Product_id', '=', 'p.Product_id')  // Changed 'product' to 'products'
            ->select('p.Product_name', DB::raw('SUM(oi.Quantity) as total_sold'))
            ->groupBy('p.Product_id', 'p.Product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    
        // Last 7 Days Sales (grouped by weekday)
        $salesData = DB::table('orders')
            ->select(DB::raw('DAYNAME(Order_date) as day_name'), DB::raw('SUM(TotalAmount) as daily_sales'))
            ->whereRaw('YEARWEEK(Order_date, 1) = YEARWEEK(CURDATE(), 1)')
            ->groupBy('day_name')
            ->pluck('daily_sales', 'day_name')
            ->toArray();
    
        // Define full week (Mon–Sun)
        $weekDays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $chartSales = [];
        foreach ($weekDays as $day) {
            $chartSales[$day] = isset($salesData[$day]) ? (float)$salesData[$day] : 0;
        }
    
        return view('AdminDashboard.Dashboard', compact(
            'totalOrders',
            'totalIncome',
            'totalCustomers',
            'topProducts',
            'chartSales'
        ));
    }

    public function logout() {
        // Clear admin session
        Session::forget('admin_logged_in');
        Session::forget('admin_username');

        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}