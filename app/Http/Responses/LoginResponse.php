<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->hasRole('pending')) {
            return redirect('/pending-approval');
        }

        if (!$user->hasAnyRole(['client', 'driver'])) {
            return redirect('/admin');
        }

        return redirect('/dashboard');
    }
}