<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\Package as PackageContract;
use Organon\Delivery\Helpers\QRGeneratorHelper;
use Organon\Marketplace\Models\SellerOrder;
use Webkul\Sales\Models\OrderItem;

class Package extends Model implements PackageContract
{
    protected $fillable = [
        'hash',
        'seller_order_id',
        'number_of_items'
    ];

    public function getQrAttribute()
    {
        return QRGeneratorHelper::fromPackage($this);
    }

    public function transactions()
    {
        return $this->hasMany(PackageTransaction::class);
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class, 'package_items');
    }

    public function sellerOrder()
    {
        return $this->belongsTo(SellerOrder::class);
    }

    public static function findByHash(string $hash, $sellerId = null)
    {
        if (!is_null($sellerId))
            return self::query()->where('hash', $hash)->whereHas('sellerOrder', function ($query) use ($sellerId) {
                $query->where('seller_orders.seller_id', $sellerId);
            })->firstOrFail();
        return self::query()->where('hash', $hash)->firstOrFail();
    }
}
