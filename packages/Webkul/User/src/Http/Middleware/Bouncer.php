<?php

namespace Webkul\User\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Event;

class Bouncer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = 'admin')
    {
        $redirectRoutes = [
            'admin' => 'admin.session.create',
            'shipping' => 'shipping.session.create',
        ];

        if (!auth()->guard($guard)->check()) {
            return redirect()->route($redirectRoutes[$guard]);
        }

        if ($guard != 'admin')
            return $next($request);

        Event::dispatch('bagisto.updates.check');

        /**
         * If user status is changed by admin. Then session should be
         * logged out.
         */
        if (!(bool) auth()->guard($guard)->user()->status) {
            auth()->guard($guard)->logout();

            return redirect()->route($redirectRoutes[$guard]);
        }


        if ($this->checkDashboard(auth()->guard($guard)->user()))
            return redirect()->route('marketplace.admin.orders.index');


        /**
         * If somehow the user deleted all permissions, then it should be
         * auto logged out and need to contact the administrator again.
         */
        if ($this->isPermissionsEmpty()) {
            auth()->guard('admin')->logout();

            session()->flash('error', __('admin::app.error.403.message'));

            return redirect()->route($redirectRoutes[$guard]);
        }

        return $next($request);
    }

    /**
     * Check for user, if they have empty permissions or not except admin.
     *
     * @return bool
     */
    public function isPermissionsEmpty()
    {
        if (!$role = auth()->guard('admin')->user()->role) {
            abort(401, 'This action is unauthorized.');
        }

        if ($role->permission_type === 'all') {
            return false;
        }

        if (
            $role->permission_type !== 'all'
            && empty($role->permissions)
        ) {
            return true;
        }

        $this->checkIfAuthorized();

        return false;
    }

    /**
     * Check authorization.
     *
     * @return null
     */
    public function checkIfAuthorized()
    {
        $acl = app('acl');

        if (!$acl) {
            return;
        }

        if (isset($acl->roles[Route::currentRouteName()])) {
            bouncer()->allow($acl->roles[Route::currentRouteName()]);
        }
    }


    private function checkDashboard($user)
    {
        return Route::currentRouteName() == 'admin.dashboard.index' && $user->isSeller();
    }
}
