<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request)
    {
        $role = $request->user()->role->lower_name;
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route($role . '.dashboard'))
            : view('auth.verify-email');
    }
}
