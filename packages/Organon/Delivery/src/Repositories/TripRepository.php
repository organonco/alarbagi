<?php

namespace Organon\Delivery\Repositories;

use Organon\Delivery\Contracts\Warehouse;
use Organon\Delivery\Models\Trip;
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
            'direction' => 0,
            'part_id' => $toWarehouse,
            'part_type' => Warehouse::class
        ]);
        foreach ($fromWarehouses as $warehouse)
            $trip->parts()->create([
                'direction' => 1,
                'part_id' => $warehouse,
                'part_type' => Warehouse::class
            ]);
    }
}
