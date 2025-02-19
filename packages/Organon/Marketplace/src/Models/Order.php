<?php

namespace Organon\Marketplace\Models;

use App\Notifications\OrderUpdated;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Organon\Delivery\Models\Area;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\ShippingCompany\Carriers\ShippingCompany;
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

	public function updateStatus(string $newStatus, bool $notify = true)
	{
		if ($this->status == $newStatus)
			return;
		$this->update(['status' => $newStatus]);
		if ($notify){
			$this->customer->notifyNow(new OrderUpdated($this->id));
		}
	}

	public function refreshStatus()
	{
		$allCount = $this->sellerOrders()->count();
		$approvedCount = $this->sellerOrders()->where('status', SellerOrderStatusEnum::APPROVED)->count();
		$rejectedCount = $this->sellerOrders()->where('status', SellerOrderStatusEnum::CANCELLED_BY_SELLER)->count();
		$pendingCount = $this->sellerOrders()->where('status', SellerOrderStatusEnum::PENDING)->count();

		if ($allCount == $approvedCount)
			$this->updateStatus(Order::STATUS_APPROVED);
		elseif ($allCount == $rejectedCount)
			$this->updateStatus(Order::STATUS_REJECTED);
		elseif ($pendingCount == 0) {
			foreach ($this->sellerOrders()->where('status', SellerOrderStatusEnum::APPROVED->value)->get() as $sellerOrder)
				foreach ($sellerOrder->items as $item)
					if ($item->product->is_deliverable)
						return $this->updateStatus(Order::STATUS_PARTIALLY_APPROVED);
			$this->updateStatus(Order::STATUS_COMPLETED);
		}
	}

	public function refreshTotals()
	{
		$invoiced = 0;
		$refunded = 0;
		$pending = 0;

		foreach ($this->items as $item)
			if ($item->status == 1)
				$invoiced += $item->total;
			elseif ($item->status == -1)
				$refunded += $item->total;
			elseif ($item->status == 0)
				$pending += $item->total;

		$newShipping = 0;

		if ($this->shipping_method == "shippingcompany_shippingcompany") {
			$newShipping = ShippingCompany::getShippingPrice($this);
			if ($this->shipping_amount > $newShipping)
				$refunded += $this->shipping_amount - $newShipping;
		}

		if ($this->shipping_method == 'wadili_wadili') {
			if ($this->sellerOrders()->where('status', SellerOrderStatusEnum::CANCELLED_BY_SELLER)->count() == $this->sellerOrders()->count()) {
				$refunded += $this->shipping_amount;
				$newShipping = 0;
			}
		}

		$this->update(['grand_total_invoiced' => $invoiced, 'grand_total_refunded' => $refunded, 'grand_total' => $this->base_grand_total - $refunded, 'shipping_invoiced' => $newShipping]);
	}

	public function approvedItems()
	{
		return $this->items()->where('status', 1);
	}

	public function getDeliverableTotalAttribute()
	{
		return $this->sellerOrders()->where('status', SellerOrderStatusEnum::APPROVED)->get()->where('is_deliverable', true)->pluck('subtotal')->sum();
	}
}
