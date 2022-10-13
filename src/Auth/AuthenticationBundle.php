<?php

declare(strict_types=1);

namespace Bima\Auth;

use Pandawa\Bundle\ResourceBundle\Plugin\ImportResourceAnnotationPlugin;
use Pandawa\Component\Foundation\Bundle\Bundle;
use Pandawa\Contracts\Foundation\HasPluginInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class AuthenticationBundle extends Bundle implements HasPluginInterface
{
    public function plugins(): array
    {
        return [
            new ImportResourceAnnotationPlugin(),
        ];
    }
}
