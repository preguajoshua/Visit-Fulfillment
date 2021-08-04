<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Redirect to Microsoft Azure for authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return Socialite::driver('azure')->redirect();
    }

    /**
     * Handle an incoming authenticated user and log them in.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $azureUser = Socialite::driver('azure')->user();

        $user = User::firstOrCreate(
            ['provider_id' => $azureUser->getId()],
            ['name' => $azureUser->getName(), 'email' => $azureUser->getEmail()]
        );

        Auth::login($user, $remember = true);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
