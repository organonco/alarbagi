<?php

namespace Webkul\Shop\Http\Controllers\Customer;

use App\Notifications\VerificationNotification;
use App\Verification;
use Closure;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Webkul\Customer\Models\Customer;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Shop\Http\Requests\Customer\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('shop::customers.forgot-password');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ForgotPasswordRequest $request
     * @return void
     */
    public function store(ForgotPasswordRequest $request)
    {
        $request->validated();

        $customer = Customer::where('phone', $request->phone)->first();

        if (is_null($customer))
            return back()
                ->withInput($request->only(['phone']))
                ->withErrors([
                    'phone' => trans('shop::app.customers.forgot-password.phone-not-exist'),
                ]);

        $verificationData = Verification::createVerification($customer);
        $customer->notify(new VerificationNotification($verificationData['code']));

        session()->flash('success', trans('shop::app.customers.signup-form.success-verify'));

        return redirect(route('shop.customers.forgot_password.verify', $verificationData['token']));
    }

    public function verify($uuid)
    {
        $verification = Verification::where('uuid', $uuid)->where('used', false)->firstOrFail();
        return view('shop::customers.reset-password', ['token' => $verification->uuid]);
    }

    public function reset($uuid)
    {
        $verification = Verification::where('uuid', $uuid)->where('used', false)->firstOrFail();
        request()->validate([
            'password' => ['required', 'confirmed'],
            'code' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) use ($verification) {
                    if (!Hash::check(request()->code, $verification->code)) {
                        $fail("كود خاطئ");
                    }
                },
            ],
        ]);
        $verification->setAsUsed();
        $verification->customer->update([
            'password' => Hash::make(request()->password)
        ]);

        session()->flash('success', trans('shop::app.customers.reset-form.success'));

        return redirect()->route('shop.customer.session.index');
    }
}
