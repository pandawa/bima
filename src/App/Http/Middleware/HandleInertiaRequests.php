<?php

namespace Bima\App\Http\Middleware;

use Bima\License\LicenseManager;
use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app::layout';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user'         => Auth::check() ? $this->userToArray(Auth::user()) : null,
            'favicon'      => config('app.favicon'),
            'app_logo'     => config('app.app_logo'),
            'sidebar_logo' => config('app.sidebar_logo'),
            'auth_logo'    => config('app.auth_logo'),
            'message'      => [
                'error'   => session('message.error'),
                'success' => session('message.success'),
            ],
            'license'      => LicenseManager::getLicense(),
        ]);
    }

    protected function userToArray(GenericUser $user): array
    {
        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ];
    }
}
