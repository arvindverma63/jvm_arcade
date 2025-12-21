<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 1. Redirect to Provider (Google/GitHub)
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // 2. Handle Callback from Provider
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Login failed, please try again.']);
        }

        // Check if user exists by Email or Provider ID
        $user = User::where('email', $socialUser->getEmail())
            ->orWhere("{$provider}_id", $socialUser->getId())
            ->first();

        if (!$user) {
            // Create new user if they don't exist
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(), // GitHub often uses nickname
                'email' => $socialUser->getEmail(),
                "{$provider}_id" => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'password' => null, // No password needed
            ]);

            Profile::create([
                'user_id' => $user->id,
                'title' => 'Novice Developer', // Default title
                'reputation' => 0,
            ]);
        } else {
            // Update existing user with latest info
            $user->update([
                "{$provider}_id" => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        }

        Auth::login($user, true); // true = "Remember Me"

        return redirect()->route('home');
    }

    // 3. Show Login Page (Now just buttons)
    public function showLogin()
    {
        return view('auth.login');
    }

    // 4. Logout
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
