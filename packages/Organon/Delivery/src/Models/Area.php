<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Area as AreaContract;
use Organon\Marketplace\Models\Seller;
use Organon\Marketplace\Traits\HasImage;
use Spatie\MediaLibrary\HasMedia;

class Area extends Model implements AreaContract, HasMedia
{
	use HasImage;

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('order', function ($builder) {
			$builder->orderBy('sort', 'asc');
		});
	}

	protected $fillable = [
		'name',
		'is_active',
		'info',
		'sort',
		'is_external'
	];

	public $appends = [
		'is_shippable'
	];

	public $hidden = [
		'created_at',
		'updated_at',
		'is_active'
	];

	public function scopeIsActive($query)
	{
		return $query->where('is_active', true);
	}

	public function shippingCompany()
	{
		return $this->hasOne(ShippingCompany::class);
	}

	public function getIsShippableAttribute()
	{
		return (!is_null($this->shippingCompany) && $this->shippingCompany->isWorking()) || $this->is_external;
	}

	public function sellers()
	{
		return $this->hasMany(Seller::class);
	}
}
