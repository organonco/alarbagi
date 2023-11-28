<?php

namespace Organon\Marketplace\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Organon\Marketplace\Repositories\SellerRepository;

class SellerAccountController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param SellerRepository $sellerRepository
     */
    public function __construct(private readonly SellerRepository $sellerRepository)
    {
    }


    public function profile()
    {
        return view('marketplace::admin.account.profile');
    }

    public function settings()
    {
        return view('marketplace::admin.account.settings');
    }
}
