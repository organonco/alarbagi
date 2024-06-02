<?php

namespace Organon\Delivery\Repositories;

use Organon\Delivery\Enums\TripStatusEnum;
use Organon\Delivery\Models\Trip;
use Organon\Delivery\Models\Warehouse;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
use Organon\Marketplace\Models\SellerOrder;
use Organon\Marketplace\Notifications\Repositories\SellerOrderRepository;
use Webkul\Core\Eloquent\Repository;

class TripRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Trip::class;
    }

    public function createPickupTrip($fromWarehouses, $toWarehouse, $driverId)
    {
        $trip = $this->create([
            'driver_id' => $driverId,
            'direction' => 0,
        ]);
        $trip->parts()->create([
            'direction' => 1,
            'part_id' => $toWarehouse,
            'part_type' => Warehouse::class
        ]);
        foreach ($fromWarehouses as $warehouse)
            $trip->parts()->create([
                'direction' => 0,
                'part_id' => $warehouse,
                'part_type' => Warehouse::class
            ]);
    }


    public function createShippingTrip($sellerOrders, $driverId)
    {
        $trip = $this->create([
            'driver_id' => $driverId,
            'direction' => 1,
        ]);

        foreach ($sellerOrders as $sellerOrder) {
            SellerOrder::query()->find($sellerOrder)->setStatus(SellerOrderStatusEnum::SHIPPING);
            $trip->parts()->create([
                'direction' => 1,
                'part_id' => $sellerOrder,
                'part_type' => SellerOrder::class
            ]);
        }
    }


    public function start(Trip $trip)
    {
        $trip->setStatus(TripStatusEnum::IN_PROGRESS);
    }


    public function finish(Trip $trip)
    {
        $repo = app(SellerOrderRepository::class);

        $trip->setStatus(TripStatusEnum::DONE);
        if (!$trip->isPickup())
            foreach ($trip->parts as $part)
                $repo->shipped($part->part);
    }
}
