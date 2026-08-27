<?php

namespace Botble\Kyc\Traits;

use Illuminate\Support\Facades\Auth;

trait DetectGuard
{
    public function detectGuard(): string
    {
        $guards = array_keys(config('auth.guards'));

        // Loop through all guards to check which one has an authenticated user
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                return $guard;  // Return the guard name if the user is authenticated
            }
        }
        return 'web';  // Default if no user is authenticated with any guard
    }
}
