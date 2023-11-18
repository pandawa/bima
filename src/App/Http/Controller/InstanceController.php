<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\Environment\Model\Environment;
use Bima\Instance\Model\Instance;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class InstanceController
{
    public function index(Request $request): Response
    {
        $environments = Environment::oldest('id')->get();
        $currentEnv = (int) $request->query('env', $environments[0]->id);

        return Inertia::render('Instance/Pages/Index', [
            'instances'    => Instance::latest()->where('environment_id', $currentEnv)->get(),
            'environments' => $environments,
            'currentEnv' => $currentEnv,
        ]);
    }

    public function show(int $id): Response
    {
        return Inertia::render('Instance/Pages/Dashboard', [
            'instance' => Instance::find($id),
        ]);
    }
}
