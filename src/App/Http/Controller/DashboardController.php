<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\Instance\Model\Instance;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class DashboardController
{
    public function index(): Response
    {
        return Inertia::render('Instance/Pages/Index', [
            'instances' => Instance::all(),
        ]);
    }
}
