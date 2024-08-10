<?php

namespace Organon\Marketplace\Http\Controllers\Shop;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Notifications\Repositories\SellerRepository;
use Organon\Marketplace\src\Contracts\Seller;
use Webkul\Shop\Mail\Customer\EmailVerificationNotification;
use Webkul\User\Repositories\AdminRepository;

class SellerController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct(public SellerRepository $sellerRepository, public AdminRepository $adminRepository)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'phone' => ['required'],
            'landline' => ['required'],
            'address' => ['required'],
            'area_id' => ['required', 'exists:areas,id'],
            'seller_category_id' => ['required', 'exists:seller_categories,id'],
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', 'min:8', Password::min(8)->letters()->numbers()],
        ]);

        $sellerData = $request->only([
            'name',
            'phone',
            'landline',
            'address',
            'area_id',
            'seller_category_id'
        ]);

        $sellerData['token'] = md5(uniqid(rand(), true));
        $sellerData['slug'] = (string)Str::uuid();

        /** @var Seller $seller */
        $seller = $this->sellerRepository->create($sellerData);

        $adminData = $request->only([
            'name',
            'email',
            'password',
        ]);

        $adminData['role_id'] = 2;
        $adminData['status'] = 1;
        $adminData['seller_id'] = $seller->id;

        if ($adminData['password'] ?? null) {
            $adminData['password'] = bcrypt($adminData['password']);
            $adminData['api_token'] = Str::random(80);
        }

        $admin = $this->adminRepository->create($adminData);

        // session()->flash('success', trans('marketplace::app.register.flash_messages.pending-verification'));

        // Mail::queue(new EmailVerificationNotification(['email' => $admin->email, 'token' => $seller->token, 'name' => $seller->name, 'seller' => true]));

        return redirect()->route('admin.session.create');
    }

    public function verifyEmail($token)
    {
        $seller = $this->sellerRepository->findOneByField('token', $token);
        if(!isset($seller)) {
            session()->flash('warning', trans('shop::app.customers.signup-form.verify-failed'));
            return redirect()->route('admin.session.create');
        }

        $this->sellerRepository->update(['token' => null], $seller->id);
        $seller->setStatus(SellerStatusEnum::PENDING);
        return redirect()->route('admin.session.create');
    }

    public function show($slug)
    {
        return view('marketplace::shop.view')->with(['seller' => $this->sellerRepository->findBySlug($slug)]);
    }
}
