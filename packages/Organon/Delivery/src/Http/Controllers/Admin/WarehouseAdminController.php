<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Organon\Delivery\Models\Warehouse;
use Organon\Delivery\DataGrids\WarehouseAdminsDataGrid;
use Organon\Delivery\Models\WarehouseAdmin;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;


class WarehouseAdminController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    private $validationRules;

    public function __construct()
    {
    }

    public function index()
    {
        if (request()->ajax())
            return app(WarehouseAdminsDataGrid::class, ['sellerId' => request()->seller_id])->toJson();
        return view('delivery::admin.warehouse_admins.index');
    }

    public function create()
    {
        return view('delivery::admin.warehouse_admins.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:warehouse_admins|max:255|email',
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
            'password' => 'required',
        ]);

        $warehouseAdmin = WarehouseAdmin::create(
            array_merge(
                $request->all(),
                [
                    'seller_id' => $this->getAuthenticatedAdmin()->getSellerId(),
                    'password' => Hash::make($request->input('password'))
                ]
            )
        );

        return redirect(route('admin.delivery.warehouse_admins.index'));
    }

    public function edit($id)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouseAdmin = WarehouseAdmin::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouseAdmin = WarehouseAdmin::findOrFail($id);

        return view('delivery::admin.warehouse_admins.edit', compact('warehouseAdmin'));
    }

    public function update($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouseAdmin = WarehouseAdmin::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouseAdmin = WarehouseAdmin::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:warehouse_admins,email,' . $warehouseAdmin->id,
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
        ]);
        $warehouseAdmin->update($request->all());

        return redirect(route('admin.delivery.warehouse_admins.index'));
    }


    public function updatePassword($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouseAdmin = WarehouseAdmin::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouseAdmin = WarehouseAdmin::findOrFail($id);
        $request->validate([
            'password' => "required|confirmed"
        ]);

        $warehouseAdmin->update(['password' => Hash::make($request->input('password'))]);

        return redirect(route('admin.delivery.warehouse_admins.index'));
    }
}
