<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $routeToRedirect = '/dashboard';

        if (Auth::user()->hasRole('Super-Admin')) {
            $routeToRedirect = route('admin.dashboard');
        }
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended($routeToRedirect); // This is the line you want to modify so the application behaves the way you want.
    }
}
