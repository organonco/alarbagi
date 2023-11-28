<?php

namespace Organon\Marketplace\Http\Controllers\Shop;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Organon\Marketplace\Repositories\SellerRepository;
use Organon\Marketplace\src\Contracts\Seller;
use Webkul\User\Repositories\AdminRepository;

class SellerController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct(public SellerRepository $sellerRepository, public AdminRepository $adminRepository)
    {
    }

    public function store(Request $request)
    {

        $sellerData = $request->only([
            'name',
            'slug'
        ]);

        /** @var Seller $seller */
        $seller = $this->sellerRepository->create($sellerData);

        $adminData = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation',
        ]);

        $adminData['role_id'] = 2;
        $adminData['status'] = 1;
        $adminData['seller_id'] = $seller->id;

        if ($adminData['password'] ?? null) {
            $adminData['password'] = bcrypt($adminData['password']);
            $adminData['api_token'] = Str::random(80);
        }

        $admin = $this->adminRepository->create($adminData);

        session()->flash('success', trans('marketplace::app.register.flash_messages.pending_approval'));

        return redirect()->route('admin.session.create');
    }
}
