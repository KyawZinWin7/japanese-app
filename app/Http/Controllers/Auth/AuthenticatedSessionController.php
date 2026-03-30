<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('vue-page', [
            'title' => 'Login',
            'pageComponent' => 'login',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'old' => [
                    'email' => old('email', ''),
                ],
                'status' => session('status'),
                'routes' => [
                    'login' => route('login.store'),
                    'register' => route('register'),
                    'google' => route('google.redirect'),
                ],
            ],
        ]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        return redirect()->intended(
            $user->is_admin
                ? route('admin.dashboard')
                : route('study.home')
        );
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out.');
    }
}
