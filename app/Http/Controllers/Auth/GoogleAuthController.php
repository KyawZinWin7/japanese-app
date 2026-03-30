<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            return redirect()->route('login')->with('status', 'Google sign-in could not be completed. Please try again.');
        }

        $user = User::query()
            ->where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if ($user) {
            $user->update([
                'name' => $googleUser->name ?: $user->name,
                'email' => $googleUser->email ?: $user->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'is_approved' => true,
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->name ?: 'Google User',
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'is_admin' => false,
                'is_approved' => true,
                'password' => Hash::make(Str::random(40)),
            ]);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route($user->is_admin ? 'admin.dashboard' : 'study.home');
    }
}
