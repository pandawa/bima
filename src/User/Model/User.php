<?php

declare(strict_types=1);

namespace Bima\User\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use Pandawa\Annotations\Resource\ApiResource;
use Pandawa\Component\Eloquent\Model;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
#[ApiResource(
    uri: 'users',
    routeGroup: 'api',
    only: ['store'],
    options: [
        'store' => [
            'middleware' => ['auth'],
            'rules' => [
                [
                    'constraints' => [
                        'name'     => 'required',
                        'email'    => 'required|email',
                        'password' => 'required',
                    ],
                ],
            ],
        ],
    ]
)]
class User extends Model
{
    protected $hidden = [
        'password',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Hash::make($value),
        );
    }
}
