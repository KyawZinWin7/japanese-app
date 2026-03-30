<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('vue-page', [
            'title' => 'Register',
            'pageComponent' => 'register',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'old' => [
                    'name' => old('name', ''),
                    'email' => old('email', ''),
                ],
                'routes' => [
                    'register' => route('register.store'),
                    'login' => route('login'),
                    'google' => route('google.redirect'),
                ],
            ],
        ]);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            ...$request->validated(),
            'is_admin' => false,
            'is_approved' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('study.home');
    }
}
