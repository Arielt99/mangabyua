<?php

namespace App\Http\Controllers\Mangaka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function authenticate(Request $request){
        // Retrive Input
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->hasRole('Mangaka')) {
            // if success login
            return redirect(route('mangaka.dashboard'));
        }
        // if failed login
        throw ValidationException::withMessages(["These credentials do not match our records."]);
    }
}
