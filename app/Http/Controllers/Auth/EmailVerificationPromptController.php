<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $role = $request->user()->role->lower_name;
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route($role . 'dashboard', absolute: false))
                    : view('auth.verify-email');
    }
}
