<?php

namespace Organon\Delivery\Http\Controllers\Shipping;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create()
    {
        if (auth()->guard('shipping')->check())
            return redirect()->route('shipping.dashboard');
        return view('delivery::shipping.session.create');
    }    

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->guard('shipping')->attempt(request(['username', 'password']), true)) {
            session()->flash('error', __('غلط في اسم المستخدم أو كلمة المرور'));
            return redirect()->back();
        }

        return redirect(route('shipping.dashboard'));
    }

    public function destroy()
    {
        auth()->guard('shipping')->logout();
        return redirect(route('shipping.session.create'));
    }
}
