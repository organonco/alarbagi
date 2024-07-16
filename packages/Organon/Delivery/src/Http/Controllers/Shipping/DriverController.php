<?php

namespace Organon\Delivery\Http\Controllers\Shipping;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Organon\Delivery\Models\Driver;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class DriverController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    use InteractsWithAuthenticatedAdmin;

    public function create(Request $request)
    {
        return view('delivery::shipping.driver.create');
    }

    public function index(Request $request)
    {
        return view('delivery::shipping.driver.index', ['drivers' => $this->getAuthenticatedShippingCompany()->drivers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required', 
        ]);
        Driver::create(array_merge($request->only(['name', 'phone', 'info']), ['shipping_company_id' => $this->getAuthenticatedShippingCompany()->id]));
        return redirect()->route('shipping.driver.index');
    }

    public function edit(Request $request, $id)
    {
        $driver = $this->getAuthenticatedShippingCompany()->drivers()->findOrFail($id);
        return view('delivery::shipping.driver.edit', ['driver' => $driver]);
    }

    public function update(Request $request, $id)
    {
        $driver = $this->getAuthenticatedShippingCompany()->drivers()->findOrFail($id);
        $request->validate([
            'name' => 'required',
            'phone' => 'required', 
        ]);
        $driver->update($request->only(['name', 'phone', 'info']));
        return redirect()->route('shipping.driver.index');
    }

}
