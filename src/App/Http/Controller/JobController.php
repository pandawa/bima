<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\Instance\Model\Instance;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class JobController
{
    public function index(int $instance, string $type): Response
    {
        return Inertia::render('Job/Pages/Index', [
            'instance' => Instance::find($instance),
            'type'     => $type,
            'current'  => $this->getCurrent($type),
        ]);
    }

    public function show(int $instance, string $type, string $job): Response
    {
        return Inertia::render('Job/Pages/Detail', [
            'instance' => Instance::find($instance),
            'current'  => $this->getCurrent($type),
            'type'     => $type,
            'job_id'   => $job,
        ]);
    }

    protected function getCurrent(string $type): string
    {
        return match ($type) {
            'pending' => 'Pending Jobs',
            'completed' => 'Completed Jobs',
        };
    }
}
