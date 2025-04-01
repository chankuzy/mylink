<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('home')
                ]);
            }
            
            
            return redirect()->intended(route('home'));
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ]
            ], 422);
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($user);

            return $request->wantsJson()
                ? response()->json(['success' => true, 'redirect' => route('home')])
                : redirect()->route('home');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'errors' => $e->errors()], 422)
                : back()->withErrors($e->errors());
        } catch (\Exception $e) {
            report($e); // Uses Laravel's error reporting system
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Registration failed'], 500)
                : back()->withErrors(['general' => 'Registration failed. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
