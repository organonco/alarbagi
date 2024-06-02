<?php

namespace Organon\Delivery\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Delivery\Enums\TripStatusEnum;
use Organon\Delivery\Repositories\TripRepository;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class TripController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __construct(private readonly TripRepository $tripRepository)
    {
    }
    public function view(Request $request, $id)
    {
        $trip = $this->getAuthenticatedDriver()->trips()->find($request->id);
        return view('delivery::driver.view-trip')->with(compact('trip'));
    }

    public function start(Request $request, $id)
    {
        $trip = $this->getAuthenticatedDriver()->trips()->find($request->id);
        $this->tripRepository->start($trip);
        return redirect(route('driver.trip.view', $id));
    }

    public function finish(Request $request, $id)
    {
        $trip = $this->getAuthenticatedDriver()->trips()->find($request->id);
        $this->tripRepository->finish($trip);
        return redirect(route('driver.trip.view', $id));
    }
}
