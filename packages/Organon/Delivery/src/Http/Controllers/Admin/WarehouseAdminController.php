<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Organon\Delivery\DataGrids\WarehouseAdminsDataGrid;
use Organon\Delivery\Models\WarehouseAdmin;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;


class WarehouseAdminController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    private $validationRules;

    public function __construct()
    {
        $this->validationRules = [
            'name' => 'required|max:255',
            'email' => 'required|unique:warehouse_admins|max:255|email',
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
            'password' => 'required'
        ];
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
        $request->validate($this->validationRules);

        WarehouseAdmin::create(
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
            $warehouse_admin = WarehouseAdmin::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouse_admin = WarehouseAdmin::findOrFail($id);
        return view('delivery::admin.warehouse_admins.edit', compact('warehouse_admin'));
    }

    public function update($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouse_admin = WarehouseAdmin::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouse_admin = WarehouseAdmin::findOrFail($id);
        $request->validate($this->validationRules);
        $warehouse_admin->update($request->all());
        return redirect(route('admin.delivery.warehouse_admins.index'));
    }


    public function updatePassword($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouse_admin = WarehouseAdmin::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouse_admin = WarehouseAdmin::findOrFail($id);
        $request->validate([
            'password' => "required|confirmed"
        ]);

        $warehouse_admin->update(['password' => Hash::make($request->input('password'))]);

        return redirect(route('admin.delivery.warehouse_admins.index'));
    }
}
