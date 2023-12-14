<?php

declare(strict_types=1);

namespace Bima\App\Http\Middleware;

use Bima\License\LicenseManager;
use Closure;
use Illuminate\Http\Request;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class ValidateLicense
{
    public function handle(Request $request, Closure $next)
    {
        if (null === $license = LicenseManager::getLicense()) {
            abort(403, 'There is no license!');
        }

        if (LicenseManager::isExpired($license)) {
            abort(403, 'Your license has expired at ' . $license['expires_at']);
        }

        return $next($request);
    }
}
