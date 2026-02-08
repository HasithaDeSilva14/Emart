<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Check if user is admin and redirect accordingly
        if (auth()->check() && auth()->user()->is_admin == 1) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/');
    }
}
