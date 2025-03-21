<?php

namespace App\Http\Middleware;

use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $gates = Gate::abilities();
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'allowedAccess' => $gates
            ],
            'menu' => MenuService::getSideBarMenu(),
        ];

        //  return array_merge(parent::share($request), [
        //     'auth' => [
        //         'user' => $request->user(),
        //     ],
        //     'menu' => MenuService::getSideBarMenu(),
        // ]);
    }
}
