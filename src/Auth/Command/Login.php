<?php

declare(strict_types=1);

namespace Bima\Auth\Command;

use Illuminate\Support\Facades\Auth;
use Pandawa\Annotations\Resource\ApiMessage;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
#[ApiMessage(
    uri: 'auth/login',
    methods: ['post'],
    routeName: 'auth.login',
    routeGroup: 'api',
    options: [
        'rules' => [
            [
                'constraints' => [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            ]
        ]
    ]
)]
class Login
{
    public function __construct(public readonly string $email, public readonly string $password)
    {
    }

    public function handle(): bool
    {
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            request()->session()->regenerate();

            return true;
        }

        return false;
    }
}
