<?php

namespace Organon\Marketplace\Http\Controllers\Shop;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Organon\Marketplace\Notifications\Repositories\SellerRepository;
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
        $request->validate([
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'alpha_dash', "unique:sellers"],
            'password' => ['required', 'confirmed', 'min:8'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'document' => ['required', 'image'],
            'document_back' => ['required', 'image'],
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


        $sellerData['is_personal'] = $request->input('is_personal') == 'on';

        /** @var Seller $seller */
        $seller = $this->sellerRepository->create($sellerData);

        $seller->setDocument('document');
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

        session()->flash('success', trans('marketplace::app.register.flash_messages.pending_approval'));

        return redirect()->route('admin.session.create');
    }

    public function show($slug)
    {
        return view('marketplace::shop.view')->with(['seller' => $this->sellerRepository->findBySlug($slug)]);
    }
}
