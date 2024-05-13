<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Organon\Delivery\DataGrids\DeliveryBoysDataGrid;
use Organon\Delivery\Models\Warehouse;
use Organon\Delivery\DataGrids\WarehouseAdminsDataGrid;
use Organon\Delivery\Models\DeliveryBoy;
use Organon\Delivery\Models\WarehouseAdmin;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;


class DeliveryBoyController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    private $validationRules;

    public function __construct()
    {
    }

    public function index()
    {
        if (request()->ajax())
            return app(DeliveryBoysDataGrid::class, ['sellerId' => request()->seller_id])->toJson();
        return view('delivery::admin.delivery_boys.index');
    }

    public function create()
    {
        return view('delivery::admin.delivery_boys.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:delivery_boys|max:255|email',
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
            'password' => 'required',
        ]);

        $deliveryBoy = DeliveryBoy::create(
            array_merge(
                $request->all(),
                [
                    'seller_id' => $this->getAuthenticatedAdmin()->getSellerId(),
                    'password' => Hash::make($request->input('password'))
                ]
            )
        );

        return redirect(route('admin.delivery.delivery_boys.index'));
    }

    public function edit($id)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $deliveryBoy = DeliveryBoy::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $deliveryBoy = DeliveryBoy::findOrFail($id);

        return view('delivery::admin.delivery_boys.edit', compact('deliveryBoy'));
    }

    public function update($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $deliveryBoy = DeliveryBoy::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $deliveryBoy = DeliveryBoy::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:delivery_boys,email,' . $deliveryBoy->id,
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
        ]);
        $deliveryBoy->update($request->all());

        return redirect(route('admin.delivery.delivery_boys.index'));
    }


    public function updatePassword($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $deliveryBoy = DeliveryBoy::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $deliveryBoy = DeliveryBoy::findOrFail($id);

        $request->validate([
            'password' => "required|confirmed"
        ]);

        $deliveryBoy->update(['password' => Hash::make($request->input('password'))]);

        return redirect(route('admin.delivery.delivery_boys.index'));
    }
}
