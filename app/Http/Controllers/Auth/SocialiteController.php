<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function redirect($provider)
    {
        // redirect user to "login with Google account" page
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        try {
            $user = Socialite::driver($provider)->stateless();
            return response()->json(['message' => 'Login successful']);
            dd($user);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Login failed'], 401);
        }
    }
}
