<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ensure only customers can access this dashboard, admins shouldn't use it
        if ($user->isAdmin()) {
            return redirect()->route('login'); // redirect to backoffice dashboard or login
        }

        return view('frontend.dashboard', compact('user'));
    }
}
