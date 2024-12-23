<?php

namespace Organon\Delivery\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Organon\Delivery\Contracts\ShippingCompany as ShippingCompanyContract;

class ShippingCompany extends Authenticatable implements ShippingCompanyContract
{
	protected $fillable = [
		'name',
		'is_active',
		'info',
		'username',
		'password',
		'area_id',
		'per_order_price',
		'per_product_price'
	];

	public function scopeIsActive($query)
	{
		return $query->where('is_active', true);
	}

	public function area()
	{
		return $this->belongsTo(Area::class);
	}

	public function drivers()
	{
		return $this->hasMany(Driver::class);
	}

	public function isWorking()
	{
		return
			$this->is_active &&
			$this->per_order_price > 0 &&
			$this->per_product_price > 0;
	}

	public function calculate($items)
	{
		$sellers = collect([]);
		foreach ($items as $item)
			if ($item->product->is_deliverable)
				$sellers->push($item->product->seller_id);
		$numberOfSellers = $sellers->unique()->count();
		if ($numberOfSellers == 0)
			return 0;
		return $this['per_order_price'] + ($this['per_product_price'] * $numberOfSellers);
	}
}
