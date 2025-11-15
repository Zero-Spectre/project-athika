<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'peran' => 'required|in:Instruktur,Peserta',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Will be hashed by mutator in User model
            'peran' => $request->peran,
        ]);

        // Log the user in
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect based on role
        return $this->redirectBasedOnRolePrivate($user);
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If user is already authenticated, redirect to their dashboard
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth.login');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        // If user is already authenticated, redirect to their dashboard
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar dalam sistem kami.',
            ])->withInput($request->only('email'));
        }

        // Verify the password manually
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Password yang Anda masukkan salah.',
            ])->withInput($request->only('email'));
        }

        // Log the user in manually
        Auth::login($user, $request->remember);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect based on role
        return $this->redirectBasedOnRole();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show the password reset form
     */
    public function showPasswordResetForm()
    {
        return view('auth.email');
    }

    /**
     * Handle password reset request
     */
    public function sendPasswordResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // In a real application, you would send an email with a reset link
        // For now, we'll just show a success message
        return back()->with('success', 'Password reset link has been sent to your email address.');
    }

    /**
     * Redirect user based on their role
     */
    public function redirectBasedOnRole()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        switch ($user->peran) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Instruktur':
                return redirect()->route('instruktur.dashboard');
            case 'Peserta':
                return redirect()->route('peserta.dashboard');
            default:
                return redirect('/');
        }
    }

    /**
     * Redirect user based on their role (private method)
     */
    private function redirectBasedOnRolePrivate($user)
    {
        switch ($user->peran) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Instruktur':
                return redirect()->route('instruktur.dashboard');
            case 'Peserta':
                return redirect()->route('peserta.dashboard');
            default:
                return redirect('/');
        }
    }
}