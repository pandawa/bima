<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\Environment\Model\Environment;
use Bima\Instance\Model\Instance;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class InstanceController
{
    public function index(): Response
    {
        return Inertia::render('Instance/Pages/Index', [
            'instances'    => Instance::all(),
            'environments' => Environment::oldest('id')->get(),
        ]);
    }

    public function show(int $id): Response
    {
        return Inertia::render('Instance/Pages/Dashboard', [
            'instance' => Instance::find($id),
        ]);
    }
}
