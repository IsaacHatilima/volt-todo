<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');
        $googleUser = $driver->stateless()->user();

        if (! isset($googleUser->user['given_name']) || ! isset($googleUser->user['family_name'])) {
            return redirect()->route('login')->with(['invalid_user' => 'Your Google account is missing names.']);
        }

        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'email' => $googleUser->email,
                'password' => Str::random(),
                'social_password' => true
            ]
        );

        $user->profile()->updateOrCreate([
            'user_id' => $user->id,
            'first_name' => $googleUser->user['given_name'],
            'last_name' => $googleUser->user['family_name']
        ]);

        // Login User after account creation.
        Auth::loginUsingId($user->id);

        return redirect()->intended('home');
    }
}
