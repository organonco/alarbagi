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
        $warehouses = Warehouse::query()->forSeller($this->getAuthenticatedAdmin()->getSellerId())->get();
        return view('delivery::admin.warehouse_admins.create', compact('warehouses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:warehouse_admins|max:255|email',
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
            'password' => 'required',
            'warehouses' => 'array'
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

        $warehouses = Warehouse::query()->forSeller($warehouseAdmin->seller_id)->whereIn('id', $request->warehouses)->get();
        $warehouseAdmin->warehouses()->sync($warehouses->pluck('id'));

        return redirect(route('admin.delivery.warehouse_admins.index'));
    }

    public function edit($id)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouseAdmin = WarehouseAdmin::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouseAdmin = WarehouseAdmin::findOrFail($id);

        $warehouses = Warehouse::query()->forSeller($warehouseAdmin->seller_id)->get();

        return view('delivery::admin.warehouse_admins.edit', compact('warehouseAdmin', 'warehouses'));
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
            'warehouses' => 'array'
        ]);
        $warehouseAdmin->update($request->all());

        $warehouses = Warehouse::query()->forSeller($warehouseAdmin->seller_id)->whereIn('id', $request->warehouses)->get();
        $warehouseAdmin->warehouses()->sync($warehouses->pluck('id'));

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

    public function createSession()
    {
        if (auth()->guard('warehouse_admin')->check())
            return redirect()->route('warehouse.dashboard');
        return view('delivery::warehouse_admin.session.create');
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->guard('warehouse_admin')->attempt(request(['email', 'password']), true)) {
            session()->flash('error', __('Incorrect Email or Password'));
            return redirect()->back();
        }

        return redirect(route('warehouse.dashboard'));
    }


    public function testView()
    {
        return view('delivery::warehouse_admin.index');
    }
}
