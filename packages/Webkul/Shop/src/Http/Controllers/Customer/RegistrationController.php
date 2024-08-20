<?php

namespace Webkul\Shop\Http\Controllers\Customer;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Cookie;
use Organon\Delivery\Models\Area;
use Organon\Marketplace\Models\SellerCategory;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Shop\Http\Requests\Customer\RegistrationRequest;
use Webkul\Shop\Mail\Customer\EmailVerificationNotification;

class RegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customer
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerGroupRepository $customerGroupRepository,
        protected SubscribersListRepository $subscriptionRepository
    )
    {
    }

    /**
     * Opens up the user's sign up form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		$areas = Area::query()->isActive()->pluck('name', 'id');
        return view('shop::customers.sign-up', compact('areas'));
    }


    /**
     * Opens up the user's sign up form.
     *
     * @return \Illuminate\View\View
     */
    public function indexSeller()
    {
        $areas = Area::query()->isActive()->pluck('name', 'id');
        $sellerCategories = SellerCategory::query()->main()->with('children')->get();
        return view('shop::customers.sign-up-seller', compact('areas', 'sellerCategories'));
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationRequest $registrationRequest)
    {
        $data = array_merge(request()->only([
            'first_name',
            'email',
            'password_confirmation',
            'is_subscribed',
			'gender',
			'phone'
        ]), [
            'password'                  => bcrypt(request()->input('password')),
            'api_token'                 => Str::random(80),
            'is_verified'               => ! core()->getConfigData('customer.settings.email.verification'),
            'customer_group_id'         => $this->customerGroupRepository->findOneWhere(['code' => 'general'])->id,
            'token'                     => md5(uniqid(rand(), true)),
            'subscribed_to_news_letter' => request()->input('is_subscribed') ?? 0,
			'date_of_birth' => request()->input('birth_y') . '-' . request()->input('birth_m') . '-' . request()->input('birth_d'),
			'last_name' => ""
        ]);

		
		$address_data = array_merge(request()->only([
			'address_details',
			'phone'
		]), [
			'name' => request()->input('first_name'),
			'area_id' => request()->input('area_id')  == "" ? null : request()->input('area_id')
		]);

        Event::dispatch('customer.registration.before');

        $customer = $this->customerRepository->create($data);
		
		$customer->addresses()->create($address_data);

        if (isset($data['is_subscribed'])) {
            $subscription = $this->subscriptionRepository->findOneWhere(['email' => $data['email']]);

            if ($subscription) {
                $this->subscriptionRepository->update([
                    'customer_id' => $customer->id,
                ], $subscription->id);
            } else {
                Event::dispatch('customer.subscription.before');

                $subscription = $this->subscriptionRepository->create([
                    'email'         => $data['email'],
                    'customer_id'   => $customer->id,
                    'channel_id'    => core()->getCurrentChannel()->id,
                    'is_subscribed' => 1,
                    'token'         => uniqid(),
                ]);

                Event::dispatch('customer.subscription.after', $subscription);
            }
        }

        Event::dispatch('customer.registration.after', $customer);

        if (core()->getConfigData('customer.settings.email.verification')) {
            session()->flash('success', trans('shop::app.customers.signup-form.success-verify'));
        } else {
            session()->flash('success', trans('shop::app.customers.signup-form.success'));
        }

        return redirect()->route('shop.customer.session.index');
    }

    /**
     * Method to verify account.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function verifyAccount($token)
    {
        $customer = $this->customerRepository->findOneByField('token', $token);

        if ($customer) {
            $this->customerRepository->update([
                'is_verified' => 1,
                'token'       => NULL,
            ], $customer->id);

            $this->customerRepository->syncNewRegisteredCustomerInformation($customer);

            auth()->guard('customer')->login($customer);
            session()->flash('success', trans('shop::app.customers.signup-form.verified'));
            return redirect()->route('shop.home.index');


        } else {
            session()->flash('warning', trans('shop::app.customers.signup-form.verify-failed'));
        }

        return redirect()->route('shop.customer.session.index');
    }

    public function resendVerificationEmail()
    {
        $email = request()->input('email');

        $verificationData = [
            'email' => $email,
            'token' => md5(uniqid(rand(), true)),
        ];

        $customer = $this->customerRepository->findOneByField('email', $email);

        $this->customerRepository->update(['token' => $verificationData['token']], $customer->id);

        try {
            Mail::queue(new EmailVerificationNotification($customer));

            if (Cookie::has('enable-resend')) {
                \Cookie::queue(\Cookie::forget('enable-resend'));
            }

            if (Cookie::has('email-for-resend')) {
                \Cookie::queue(\Cookie::forget('email-for-resend'));
            }
        } catch (\Exception $e) {
            report($e);

            session()->flash('error', trans('shop::app.customers.signup-form.verification-not-sent'));

            return redirect()->back();
        }

        session()->flash('success', trans('shop::app.customers.signup-form.verification-sent'));

        return redirect()->back();
    }

    public function showResendVerificationEmail()
    {
        $email = request()->email;
        return view('shop::customers.resend-email', ['email' => $email]);
    }
}
