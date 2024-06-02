<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Enums\TripStatusEnum;
use Organon\Delivery\Models\Driver;
use Organon\Delivery\Models\Trip;
use Organon\Delivery\Models\Warehouse;
use Organon\Delivery\Repositories\TripRepository;
use Organon\Marketplace\Models\SellerOrder;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;


class TripController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __construct(private readonly TripRepository $tripRepository)
    {
    }

    public function index(Request $request)
    {
        $availableDrivers = Driver::query()->isAvailable()->get();
        $pendingWarehouses = Warehouse::query()->isPending()->whereNotNull('seller_id')->get();
        $shippableOrders = SellerOrder::query()->isShippable()->get()->groupBy('order_id');

        $tripsStatus = $request->status ? $request->status : TripStatusEnum::IN_PROGRESS->value;
        $trips = Trip::where('status', $tripsStatus)->get();

        return view('delivery::admin.trips.index', compact('availableDrivers', 'pendingWarehouses', 'shippableOrders', 'trips', 'tripsStatus'));
    }

    public function createPickup(Request $request)
    {
        $drivers = Driver::pluck('name', 'id');
        $sellerWarehouses = Warehouse::query()->isPending()->whereNotNull('seller_id')->get()->groupBy("emirate");
        $adminWarehouses = Warehouse::whereNull('seller_id')->pluck('name', 'id');
        return view('delivery::admin.trips.create-pickup', compact('drivers', 'sellerWarehouses', 'adminWarehouses'));
    }

    public function createShipping(Request $request)
    {
        $drivers = Driver::pluck('name', 'id');
        $sellerOrders = SellerOrder::query()->isShippable()->get();
        return view('delivery::admin.trips.create-shipping', compact('drivers', 'sellerOrders'));
    }

    public function store(Request $request)
    {
        if ($request->direction == "0") {
            $request->validate([
                'driver_id' => 'required',
                'from_warehouses' => 'required|array',
                'to_warehouse' => 'required',
            ]);
            $this->tripRepository->createPickupTrip($request->from_warehouses, $request->to_warehouse, $request->driver_id);
        } elseif ($request->direction == "1") {
            $request->validate([
                'driver_id' => 'required',
                'seller_orders' => 'required|array',
            ]);
            $this->tripRepository->createShippingTrip($request->seller_orders, $request->driver_id);
        }
        return redirect(route('admin.delivery.trips.index'));
    }
}
