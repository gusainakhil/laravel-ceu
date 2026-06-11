<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendCredentialsMail;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        if ($request->filled('redirect')) {
            session(['url.intended' => $request->query('redirect')]);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success', 'Welcome back, ' . Auth::user()->name . '! Logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function sendCredentials(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        // Always show success to avoid email enumeration
        if (!$user) {
            return back()->with('credentials_sent', 'If that email exists in our system, you will receive your credentials shortly.');
        }

        $namePart  = strtolower(substr(preg_replace('/[^a-zA-Z]/', '', $user->name), 0, 4));
        $phoneOnly = preg_replace('/\D/', '', (string) $user->phone);
        $phonePart = strlen($phoneOnly) >= 4 ? substr($phoneOnly, -4) : str_pad($phoneOnly, 4, (string) rand(0, 9));
        $plainPassword = $namePart . $phonePart;

        $user->update(['password' => Hash::make($plainPassword)]);

        MailService::send($user->email, new SendCredentialsMail($user, $plainPassword));

        return back()->with('credentials_sent', 'Your credentials have been sent to your email address.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
