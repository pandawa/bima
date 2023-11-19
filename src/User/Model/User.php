<?php

declare(strict_types=1);

namespace Bima\User\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use Pandawa\Component\Eloquent\Model;


class User extends Model
{
    protected $hidden = [
        'password',
    ];

    public static function newPassword(): string
    {
        return substr(base64_encode(uniqid()), 0, 18);
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Hash::make($value),
        );
    }
}
