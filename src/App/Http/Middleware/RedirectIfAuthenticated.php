<?php

declare(strict_types=1);

namespace Bima\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pandawa\Annotations\Routing\AsMiddleware;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
#[AsMiddleware('guest')]
class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect('/instances');
            }
        }

        return $next($request);
    }
}
