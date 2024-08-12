<?php

namespace Organon\Marketplace\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Organon\Delivery\Models\Area;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Webkul\Sales\Models\OrderAddress;

class Order extends \Webkul\Sales\Models\Order
{
	/**
	 * @return HasMany
	 */
	public function sellerOrders(): HasMany
	{
		return $this->hasMany(SellerOrderProxy::modelClass());
	}

	public function canCancel(): bool
	{
		foreach ($this->sellerOrders as $sellerOrder)
			if ($sellerOrder->status == SellerOrderStatusEnum::APPROVED)
				return false;
		return parent::canCancel(); // TODO: Change the autogenerated stub
	}

	public function canShip(): bool
	{
		return false;
	}

	public function canInvoice(): bool
	{
		return false;
	}

	public function canRefund(): bool
	{
		return false;
	}

	public function scopeForShippingCompany($query, $shippingCompany)
	{
		return $query->where('shipping_method', 'shippingcompany_shippingcompany')->whereHas('addresses', function ($query) use ($shippingCompany) {
			return $query->where('address_type', OrderAddress::ADDRESS_TYPE_SHIPPING)->where('area_id', $shippingCompany->area_id);
		});
	}

	public function getShippingDetailsAttribute()
	{
		return [
			'address' => [
				'customer_name' => $this->shipping_address->name,
				'details' => $this->shipping_address->address_details,
				'pickup_areas' => implode(" - ", Area::whereIn('id', $this->sellerOrders()->with('seller')->get()->pluck('seller.area_id'))->pluck('name')->toArray()),
				'number' => $this->shipping_address->phone,
			],
			'date' => date_format($this->created_at, "d/m/Y"),
			'time' => date_format($this->created_at, "H:i")
		];
	}
}
