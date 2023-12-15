<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        //if($request->is(['manage', 'manage/*'])){
        //dd(Auth()->user());
        //dd($request->is(['manage', 'manage/*']));
        //}
        $rolePermissions = $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name')->toArray() : [];
        $userPermission = $request->user() ? $request->user()->permissions()->pluck('name')->toArray() : [];
        $permissions = array_merge($rolePermissions, $userPermission);
        return array_merge(parent::share($request), [
            'user.roles' => $request->user() ? $request->user()->roles->pluck('name') : [],
            //'user.permissions' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : [],
            'user.permissions' => $permissions,
            'current_organization' => session('organization'),
            'by_guardian' => session('guardian'),
            'lang' => session('applocale'),
            'lt'=>$request->session()->get('lt')
        ]);
    }
}
