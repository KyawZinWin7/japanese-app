<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function edit(Request $request)
    {
        return view('vue-page', [
            'title' => 'Change Password',
            'pageComponent' => 'change-password',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'status' => session('status'),
                'user' => [
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                ],
                'routes' => [
                    'profile' => route('profile.show'),
                    'updatePassword' => route('password.update'),
                ],
            ],
        ]);
    }

    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => $request->validated('password'),
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('password.edit')
            ->with('status', 'Your password has been updated.');
    }
}
