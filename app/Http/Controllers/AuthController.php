<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Notifications\UserActionNotification;

class AuthController extends Controller
{
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
            // --- NEW USER REGISTRATION ---
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                "{$provider}_id" => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'password' => null,
            ]);

            Profile::create([
                'user_id' => $user->id,
                'title' => 'Novice Developer',
                'reputation' => 0,
            ]);

            // [NOTIFICATION] Send Welcome Notification
            $user->notify(new UserActionNotification("Welcome to the community, {$user->name}! Setup your profile to get started."));
        } else {
            // --- EXISTING USER LOGIN ---

            // Update existing user with latest info
            $user->update([
                "{$provider}_id" => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);

        }

        Auth::login($user, true);

        return redirect()->route('home');
    }

    // 3. Show Login Page
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
