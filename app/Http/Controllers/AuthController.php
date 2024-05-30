<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Fetch the latest organization ID and increment it
        $latestOrganization = User::orderBy('organization_id', 'desc')->first();
        $newOrganizationId = $latestOrganization ? $latestOrganization->organization_id + 1 : 1;

        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create and save the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'roles' => 'admin',
            'organization_id' => $newOrganizationId,
            'stage_completed' => '0'
        ]);

        // Log in the user
        Auth::login($user);

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Find the user by username
        $user = User::where('name', $request->username)->first();
    
        // Check if user exists and if the provided password matches the stored password
        if ($user && Hash::check($request->password, $user->password)) {
            // User authenticated, select the necessary fields
            $user = User::where('name', $request->username)->select('id', 'name', 'roles', 'organization_id')->first();
    
            // Redirect based on user role
            if ($user->roles == 'admin') {
                return response()->json(['redirect' => '/dashboard/admin', 'user' => $user]);
            } else if ($user->roles == 'user') {
                return response()->json(['redirect' => '/modules-view/1', 'user' => $user]);
            }
        }
    
        // Authentication failed
        return redirect()->back()->withInput($request->only('username'))->withErrors([
            'username' => 'These credentials do not match our records.',
        ]);
    }
    

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
