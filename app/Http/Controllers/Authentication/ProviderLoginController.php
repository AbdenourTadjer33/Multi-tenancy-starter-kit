<?php

namespace App\Http\Controllers\Authentication;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderLoginController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            $user = User::firstOrCreate(
                [
                    'email' => $socialUser->getEmail()
                ],
                [
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'email_verified_at' => Carbon::now(),
                    'password' => bcrypt(Str::random(24)),
                    'profile_photo' => $socialUser->getAvatar(),
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                ]
            );

            Auth::login($user);

            return redirect()->intended("dashboard");
        } catch (\Throwable $th) {
            logger($th);
            return redirect()->route('register');
        }
    }
}
