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
		'km_price',
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
			$this->km_price > 0;
	}
}
