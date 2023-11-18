<?php

declare(strict_types=1);

namespace Bima\Environment;

use Pandawa\Bundle\DatabaseBundle\Plugin\ImportMigrationPlugin;
use Pandawa\Bundle\ResourceBundle\Plugin\ImportResourceAnnotationPlugin;
use Pandawa\Component\Foundation\Bundle\Bundle;
use Pandawa\Contracts\Foundation\HasPluginInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class EnvironmentBundle extends Bundle implements HasPluginInterface
{
    public function plugins(): array
    {
        return [
            new ImportMigrationPlugin(),
            new ImportResourceAnnotationPlugin(),
        ];
    }
}
