<?php

namespace Organon\Marketplace\Http\Controllers\Shop;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
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
            'password' => ['required', 'confirmed', 'min:8'],
            'email' => ['required', 'email', 'unique:admins'],
            'phone' => ['required'],
            'document' => ['required', File::types(['jpeg', 'jpg', 'png', 'webp', 'pdf'])],
            'document_back' => ['required_if:is_personal,on', File::types(['jpeg', 'jpg', 'png', 'webp', 'pdf'])],
            'additional_phone' => ['different:phone'],
            'additional_email' => ['different:email']
        ]);

        $sellerData = $request->only([
            'name',
            'slug',
            'phone',
            'additional_phone',
            'additional_email',
            'landline',
            'address'
        ]);

        $sellerData['token'] = md5(uniqid(rand(), true));

        $sellerData['is_personal'] = $request->input('is_personal') == 'on';

        /** @var Seller $seller */
        $seller = $this->sellerRepository->create($sellerData);

        $seller->setDocument('document');

        if ($sellerData['is_personal'])
            $seller->setDocumentBack('document_back');

        $adminData = $request->only([
            'name',
            'email',
            'password'
        ]);

        $adminData['role_id'] = 2;
        $adminData['status'] = 1;
        $adminData['seller_id'] = $seller->id;

        if ($adminData['password'] ?? null) {
            $adminData['password'] = bcrypt($adminData['password']);
            $adminData['api_token'] = Str::random(80);
        }

        $admin = $this->adminRepository->create($adminData);

        session()->flash('success', trans('marketplace::app.register.flash_messages.pending-verification'));

        Mail::queue(new EmailVerificationNotification(['email' => $admin->email, 'token' => $seller->token, 'name' => $seller->name, 'seller' => true]));

        return redirect()->route('admin.session.create');
    }

    public function verifyEmail($token)
    {
        $seller = $this->sellerRepository->findOneByField('token', $token);
        if (!isset($seller)) {
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
