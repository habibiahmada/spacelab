<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if (! Hash::check($value, $request->user()->password_hash)) {
                        $fail(__('The password is incorrect.'));
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password_hash' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
