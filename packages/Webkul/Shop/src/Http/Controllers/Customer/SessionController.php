<?php

namespace Webkul\Shop\Http\Controllers\Customer;

use App\Notifications\VerificationNotification;
use App\Verification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Models\Customer;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Shop\Http\Requests\Customer\LoginRequest;

class SessionController extends Controller
{
    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show()
    {
        return auth()->guard('customer')->check()
            ? redirect()->route('shop.home.index')
            : view('shop::customers.sign-in');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LoginRequest $loginRequest)
    {
        if (! auth()->guard('customer')->attempt($loginRequest->only(['phone', 'password']), true)) {
            session()->flash('error', trans('shop::app.customers.login-form.invalid-credentials'));

            return redirect()->back();
        }

        if (! auth()->guard('customer')->user()->status) {
            auth()->guard('customer')->logout();

            session()->flash('warning', trans('shop::app.customers.login-form.not-activated'));

            return redirect()->back();
        }

        if (! auth()->guard('customer')->user()->is_verified) {
            session()->flash('info', trans('shop::app.customers.login-form.verify-first'));

            /** @var Customer */
            $customer = auth()->guard('customer')->user();
            auth()->guard('customer')->logout();

            $verificationData = Verification::createVerification($customer);
            $customer->notify(new VerificationNotification($verificationData['code']));
            return redirect()->route('shop.customers.register.verify.show', $verificationData['token']);
        }

        /**
         * Event passed to prepare cart after login.
         */
        // Event::dispatch('customer.after.login', $loginRequest->get('email'));
 
        return redirect()->route('shop.home.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->guard('customer')->logout();

        Event::dispatch('customer.after.logout', $id);

        return redirect()->route('shop.home.index');
    }
}
