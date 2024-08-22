<?php

namespace Organon\Delivery\Http\Controllers\Shipping;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Marketplace\Models\Order;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class OrderController extends Controller
{
	use InteractsWithAuthenticatedAdmin;


	public function index()
	{
		$shippingCompany = $this->getAuthenticatedShippingCompany();
		$orders = Order::query()->forShippingCompany($shippingCompany)->get();
		$pendingOrders = $orders->where('status', Order::STATUS_PROCESSING);
		return view('delivery::shipping.dashboard.index', compact('pendingOrders'));
	}

	public function show($id)
	{
		$shippingCompany = $this->getAuthenticatedShippingCompany();
		$order = Order::query()->forShippingCompany($shippingCompany)->findOrFail($id);
		$drivers = $shippingCompany->drivers()->get(["name", "phone"]);
		return view('delivery::shipping.dashboard.show', compact('order', 'drivers'));
	}

	public function updateShippingPrice(Request $request, $id)
	{
		$request->validate(['price' => 'required|numeric']);
		$shippingCompany = $this->getAuthenticatedShippingCompany();
		$order = Order::query()->forShippingCompany($shippingCompany)->findOrFail($id);

		$price = $request->input('price');
		$order->update([
			'shipping_amount' => $price,
			'base_shipping_amount' => $price,
			'grand_total' => $price + $order->grand_total,
			'base_grand_total' => $price + $order->base_grand_total
		]);
		return redirect()->route('shipping.orders.show', $id);
	}
}
