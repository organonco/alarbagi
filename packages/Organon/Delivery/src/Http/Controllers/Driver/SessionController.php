<?php

namespace Organon\Delivery\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class SessionController extends Controller
{
    public function create()
    {
        if (auth()->guard('driver')->check())
            return redirect()->route('driver.dashboard');
        return view('delivery::driver.session.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->guard('driver')->attempt(request(['email', 'password']), true)) {
            session()->flash('error', __('Incorrect Email or Password'));
            return redirect()->back();
        }

        return redirect(route('driver.dashboard'));
    }

    public function destroy()
    {
        auth()->guard('driver')->logout();
        return redirect(route('driver.session.create'));
    }
}
