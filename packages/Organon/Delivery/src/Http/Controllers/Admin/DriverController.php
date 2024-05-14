<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Organon\Delivery\DataGrids\DriversDataGrid;
use Organon\Delivery\Models\Driver;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;


class DriverController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    private $validationRules;

    public function __construct()
    {
    }

    public function index()
    {
        if (request()->ajax())
            return app(DriversDataGrid::class, ['sellerId' => request()->seller_id])->toJson();
        return view('delivery::admin.drivers.index');
    }

    public function create()
    {
        return view('delivery::admin.drivers.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:drivers|max:255|email',
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
            'password' => 'required',
        ]);

        $deliveryBoy = Driver::create(
            array_merge(
                $request->all(),
                [
                    'seller_id' => $this->getAuthenticatedAdmin()->getSellerId(),
                    'password' => Hash::make($request->input('password'))
                ]
            )
        );

        return redirect(route('admin.delivery.drivers.index'));
    }

    public function edit($id)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $deliveryBoy = Driver::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $deliveryBoy = Driver::findOrFail($id);

        return view('delivery::admin.drivers.edit', compact('deliveryBoy'));
    }

    public function update($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $deliveryBoy = Driver::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $deliveryBoy = Driver::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:drivers,email,' . $deliveryBoy->id,
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
        ]);
        $deliveryBoy->update($request->all());

        return redirect(route('admin.delivery.drivers.index'));
    }


    public function updatePassword($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $deliveryBoy = Driver::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $deliveryBoy = Driver::findOrFail($id);

        $request->validate([
            'password' => "required|confirmed"
        ]);

        $deliveryBoy->update(['password' => Hash::make($request->input('password'))]);

        return redirect(route('admin.delivery.drivers.index'));
    }
}
