<?php

namespace Organon\Delivery\Repositories;

use Organon\Delivery\Interfaces\PackageHolder;
use Organon\Delivery\Models\Package;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\SellerOrder;
use Vinkla\Hashids\Facades\Hashids;
use Webkul\Core\Eloquent\Repository;

class PackageRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Package::class;
    }

    private function updateHash(Package $package)
    {
        $package->update(['hash' => Hashids::encode($package->id)]);
        return $package->refresh();
    }


    private function updateSellerOrderStatus(Package $package, PackageHolder $packageHolder)
    {
        if ($packageHolder->isForSeller())
            $package->sellerOrder->setStatus(SellerOrderStatusEnum::READY_FOR_PICKUP);
        else
            if ($packageHolder->getType() == 'driver')
            $package->sellerOrder->setStatus(SellerOrderStatusEnum::PICKED_UP);
        elseif ($packageHolder->getType() == 'warehouse')
            $package->sellerOrder->setStatus(SellerOrderStatusEnum::READY_FOR_SHIPPING);
    }


    public function addTransaction(Package $package, PackageHolder $holder)
    {
        $package->transactions()->update(['until' => now()]);
        $holder->packageTransactions()->create([
            'package_id' => $package->id,
        ]);
        $this->updateSellerOrderStatus($package, $holder);
    }

    public function fromSellerOrder(SellerOrder $sellerOrder)
    {
        if ($sellerOrder->hasPackage())
            return $sellerOrder->package;

        /** @var Package */
        $package = $this->updateHash(Package::create([
            'seller_order_id' => $sellerOrder->id,
            'number_of_items' => $sellerOrder->items()->count()
        ]));
        foreach ($sellerOrder->items as $item) {
            $package->packageItems()->create(['order_item_id' => $item->id]);
        }
        return $package;
    }
}
