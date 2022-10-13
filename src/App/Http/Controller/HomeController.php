<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Illuminate\Http\RedirectResponse;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class HomeController
{
    public function index(): RedirectResponse
    {
        return new RedirectResponse(route('instance.list'));
    }
}
