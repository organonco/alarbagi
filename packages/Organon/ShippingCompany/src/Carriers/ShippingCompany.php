<?php

namespace Organon\ShippingCompany\Carriers;

use Config;
use Illuminate\Support\Facades\Http;
use Organon\Marketplace\Models\Order;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\Cart as ModelsCart;
use Webkul\Shipping\Carriers\AbstractShipping;
use Webkul\Checkout\Models\CartShippingRate;

class ShippingCompany extends AbstractShipping
{
	/**
	 * Shipping method code
	 *
	 * @var string
	 */
	protected $code  = 'shippingcompany';

	/**
	 * @param int $price
	 * @return CartShippingRate
	 */
	private function getCartShippingRateObject(): CartShippingRate
	{
		$object = new CartShippingRate;

		$object->carrier = 'shippingcompany';
		$object->carrier_title = '';
		$object->method = 'shippingcompany_shippingcompany';
		$object->method_title = $this->getConfigData('title');
		$object->method_icon = $this->getIcon();

		return $object;
	}

	private function generateUnavailableObject(string $key)
	{
		return [
			'isAvailable' => false,
			'reason' => trans('shipping-company::app.messages.' . $key)
		];
	}

	private static function hasValue($value)
	{
		return !is_null($value) && !$value == "";
	}

	private static function addressIsvalid($address)
	{
		$values = [$address->lat, $address->lng, $address->street, $address->building, $address->floor, $address->area_id, $address->address_details];
		foreach ($values as $value)
			if (!self::hasValue($value))
				return false;
		return true;
	}

	private function checkAvailability()
	{
		$cart = Cart::getCart();
		$shippingAddress = $cart->shipping_address;

		if (!$cart->hasDeliverableItems())
			return $this->generateUnavailableObject('no-deliverable-items');
		if (!self::addressIsvalid($shippingAddress))
			return $this->generateUnavailableObject('address-or-area-not-found');
		if (!$shippingAddress->area->is_shippable)
			return $this->generateUnavailableObject('delivery-not-available-to-this-area');;

		return [
			'isAvailable' => true,
			'sameArea' => $this->sameArea($cart->shipping_address->area_id, $cart)
		];
	}


	private function sameArea(int $areaId, $cart)
	{
		foreach ($cart->items as $item)
			if ($item->product->getSellerAreaId() != $areaId)
				return false;
		return true;
	}


	public static function getShippingPrice($order): int
	{
		$kmPrice = $order->shipping_address->area->shippingCompany->km_price;
		$sellers = collect([]);

		foreach ($order->items as $item)
			if ($item->product->is_deliverable)
				if ($order instanceof ModelsCart || ($order instanceof Order && $item->status != -1))
					$sellers->push($item->product->seller);

		$sellers->unique('id');

		$destinations = collect([]);
		foreach ($sellers as $seller)
			$destinations->push(['lat' => $seller->lat, 'lng' => $seller->lng]);

		$origin = [
			'lat' => $order->shipping_address->lat,
			'lng' => $order->shipping_address->lng
		];

		$distance = self::getDistance($origin, $destinations);

		return $kmPrice * $distance / 1000;
	}

	public static function getDistance($origin, $destinations)
	{
		$waypoints = "";
		$destinationsCount = $destinations->count();
		if ($destinationsCount == 0)
			return 0;
		
		if ($destinationsCount > 1)
			for ($i = 1; $i < $destinationsCount; $i++)
				$waypoints .= $destinations[$i]['lat'] . ',' . $destinations[$i]['lng'];

		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'Accept' => "*/*",
			'Accept-Encoding' => "gzip, deflate, br",
			'Accept-Language' => "*"
		])->get('https://maps.googleapis.com/maps/api/directions/json', [
			'origin' => $origin['lat'] . ',' . $origin['lng'],
			'destination' => $destinations[0]['lat'] . ',' . $destinations[0]['lng'],
			'waypoints' => $waypoints,
			'key' => config('google.key')
		]);

		$distance = 0;

		foreach (json_decode($response->body())->routes[0]->legs as $leg)
			$distance += $leg->distance->value;
		return $distance;
	}

	/**
	 * @return CartShippingRate|false
	 */
	public function calculate()
	{
		$object = $this->getCartShippingRateObject();
		$availability = $this->checkAvailability();

		$object->is_available = $availability['isAvailable'];
		$object->is_visible = $this->isVisible();

		if ($object->is_available) {
			$price = self::getShippingPrice(Cart::getCart());
			$object->price = $price;
			$object->base_price = $price;
			$object->method_description = $this->getConfigData('description');
		} else {
			$object->method_description = $availability['reason'];
		}

		return $object;
	}

	public function isVisible()
	{
		$cart = Cart::getCart();
		$shippingAddress = $cart->shipping_address;
		return !($shippingAddress->area ? $shippingAddress->area->is_external : false);
	}
}
