<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\User\Model\User;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class UserController
{
    public function index(): Response
    {
        return Inertia::render('User/Pages/Index', [
            'users' => User::latest()->get(),
        ]);
    }
}
