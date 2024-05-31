<?php

namespace Organon\Delivery\Http\Controllers\WarehouseAdmin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class SessionController extends Controller
{
    public function create()
    {
        if (auth()->guard('warehouse_admin')->check())
            return redirect()->route('warehouse.dashboard');
        return view('delivery::warehouse_admin.session.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->guard('warehouse_admin')->attempt(request(['email', 'password']), true)) {
            session()->flash('error', __('Incorrect Email or Password'));
            return redirect()->back();
        }

        return redirect(route('warehouse.dashboard'));
    }

    public function destroy()
    {
        auth()->guard('warehouse_admin')->logout();
        return redirect(route('warehouse.session.create'));
    }
}
