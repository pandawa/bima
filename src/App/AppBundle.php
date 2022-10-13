<?php

declare(strict_types=1);

namespace Bima\App;

use Inertia\Inertia;
use Pandawa\Bundle\RoutingBundle\Plugin\ImportMiddlewareAnnotationPlugin;
use Pandawa\Bundle\RoutingBundle\Plugin\ImportRoutesPlugin;
use Pandawa\Bundle\ViewBundle\Plugin\RegisterViewPathPlugin;
use Pandawa\Component\Foundation\Bundle\Bundle;
use Pandawa\Contracts\Foundation\HasPluginInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class AppBundle extends Bundle implements HasPluginInterface
{
    public function configure(): void
    {
        Inertia::setRootView('app::layout');
    }

    public function plugins(): array
    {
        return [
            new RegisterViewPathPlugin(),
            new ImportRoutesPlugin(),
            new ImportMiddlewareAnnotationPlugin(),
        ];
    }
}
