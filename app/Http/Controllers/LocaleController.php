<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', 'in:en,my'],
            'redirect_to' => ['nullable', 'string'],
        ]);

        $request->session()->put('locale', $validated['locale']);

        $redirectTo = $validated['redirect_to'] ?? url()->previous();

        return redirect()->to($redirectTo);
    }
}
