<?php

namespace Webkul\Admin\Http\Controllers\User;

use Organon\Marketplace\Enums\SellerStatusEnum;
use Webkul\Admin\Http\Controllers\Controller;

class SessionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (auth()->guard('admin')->check()) {
            if (auth('admin')->user()->isSeller()) {
                return redirect(route('marketplace.admin.orders.index'));
            }
            return redirect()->route('admin.dashboard.index');
        }

        if (strpos(url()->previous(), 'admin') !== false) {
            $intendedUrl = url()->previous();
        } else {
            $intendedUrl = route('admin.dashboard.index');
        }

        session()->put('url.intended', $intendedUrl);

        return view('admin::users.sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = request('remember');

        if (!auth()->guard('admin')->attempt(request(['email', 'password']), $remember)) {
            session()->flash('error', trans('admin::app.settings.users.login-error'));

            return redirect()->back();
        }

        if (!auth()->guard('admin')->user()->status) {
            session()->flash('warning', trans('admin::app.settings.users.activate-warning'));

            auth()->guard('admin')->logout();

            return redirect()->route('admin.session.create');
        }


        if (auth('admin')->user()->isSeller()) {
            $seller = auth('admin')->user()->getSeller();
            if ($seller->status == SellerStatusEnum::UNVERIFIED) {
                session()->flash('warning', trans('marketplace::app.register.flash_messages.pending-verification'));
                auth()->guard('admin')->logout();
                return redirect()->route('admin.session.create');
            }
        }

        return redirect(route('marketplace.admin.orders.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy()
    {
        auth()->guard('admin')->logout();

        return redirect()->route('admin.session.create');
    }
}
