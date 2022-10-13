<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class AuthController
{
    public function login(): Response
    {
        return Inertia::render('Auth/Pages/Login');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return new RedirectResponse(route('login'));
    }
}
