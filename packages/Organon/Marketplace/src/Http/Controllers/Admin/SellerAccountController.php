<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Organon\Marketplace\Enums\SellerStatusEnum;
use Organon\Marketplace\Notifications\Repositories\SellerRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class SellerAccountController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, InteractsWithAuthenticatedAdmin;

    /**
     * @param SellerRepository $sellerRepository
     */
    public function __construct(private readonly SellerRepository $sellerRepository)
    {
    }


    public function profile()
    {
        return view('marketplace::admin.account.profile')->with([
            'seller' => $this->getAuthenticatedSeller()
        ]);
    }

    public function updateProfile(Request $request)
    {

        $seller = $this->getAuthenticatedSeller();
        $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['max:1000'],
            'address' => ['max: 1000'],
            'logo' => ['image'],
			'opening_days' => ['required', 'max:255'],
			'opening_time' => ['required', 'max:255'],
			'owner_name' => ['required', 'max:255'],
        ]);
        $seller->update($request->all());
        if($request->hasFile('logo'))
            $seller->setLogo('logo');

        $this->getAuthenticatedAdmin()->update([
            'name' => $request->get('name')
        ]);

        session()->flash('success', trans('marketplace::app.admin.account.profile.flash_messages.updated'));

        return redirect(route('admin.account.profile.view'));
    }

    public function settings()
    {
        return view('marketplace::admin.account.settings')->with([
            'seller' => $this->getAuthenticatedSeller()
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current' => ['required', 'current_password:admin'],
            'new' => ['required', 'confirmed', 'min:8']
        ]);
        $this->getAuthenticatedAdmin()->update(['password' => Hash::make($request->get('new'))]);

        session()->flash('success', trans('marketplace::app.admin.account.settings.flash_messages.password-updated'));
        return redirect(route('admin.account.settings.view'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', 'max:4000'],
            'deliver_by' => ['required', 'numeric', 'min:1'],
        ]);
        $this->getAuthenticatedSeller()->update([
            'payment_method' => $request->get('payment_method'),
            'deliver_by' => $request->get('deliver_by'),
        ]);
        return redirect(route('admin.account.settings.view'));
    }

    public function updateAccountStatus(Request $request)
    {
        $seller = $this->getAuthenticatedSeller();
        if($request->active == 'active' && $seller->isUnpauseable())
            $seller->setStatus(SellerStatusEnum::ACTIVE);
        elseif($request->active != 'active' && $seller->isPauseable())
            $seller->setStatus(SellerStatusEnum::PAUSED);
        return redirect(route('admin.account.settings.view'));
    }
}
