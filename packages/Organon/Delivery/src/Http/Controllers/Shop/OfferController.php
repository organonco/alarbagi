<?php

namespace Organon\Delivery\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Organon\Marketplace\Models\Offer;
use Webkul\Customer\Models\Customer;

class OfferController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
		/** @var Customer */
		$authenticatedUser = auth()->guard('customer')->user();
		if($authenticatedUser)
			$authenticatedUser->offersNotifications()->update(['read_at' => now()]);

        $offers = Offer::query()->isActive()->latest()->get();
        return view('shop::offers.index')->with(compact('offers'));
    }
}
