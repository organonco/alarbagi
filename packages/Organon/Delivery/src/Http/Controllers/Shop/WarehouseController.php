<?php

namespace Organon\Delivery\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rules\Enum;
use Organon\Delivery\DataGrids\WarehousesDataGrid;
use Organon\Delivery\Enums\EmiratesEnum;
use Organon\Delivery\Models\Warehouse;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;

class WarehouseController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    private $validationRules;

    public function __construct()
    {
        $this->validationRules = [
            'name' => 'required|max:255',
            'additional_info' => 'string|max:3000',
            'address' => 'string|max:3000',
            'emirate' => ['required', 'string', new Enum(EmiratesEnum::class)]
        ];
    }

    public function index()
    {
        if (request()->ajax())
            return app(WarehousesDataGrid::class, ['sellerId' => request()->seller_id])->toJson();
        return view('delivery::admin.warehouses.index');
    }

    public function create()
    {
        $emirates = array_column(EmiratesEnum::cases(), 'value');
        return view('delivery::admin.warehouses.create', compact('emirates'));
    }


    public function store(Request $request)
    {
        $request->validate($this->validationRules);
        Warehouse::create(array_merge($request->all(), ['seller_id' => $this->getAuthenticatedAdmin()->getSellerId()]));

        return redirect(route('admin.delivery.warehouses.index'));
    }

    public function edit($id)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouse = Warehouse::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouse = Warehouse::findOrFail($id);
        $emirates = array_column(EmiratesEnum::cases(), 'value');
        return view('delivery::admin.warehouses.edit', compact('warehouse', 'emirates'));
    }

    public function update($id, Request $request)
    {
        if ($this->getAuthenticatedAdmin()->isSeller())
            $warehouse = Warehouse::where('seller_id', $this->getAuthenticatedAdmin()->getSellerId())->findOrFail($id);
        else
            $warehouse = Warehouse::findOrFail($id);
        $request->validate($this->validationRules);
        $warehouse->update($request->all());
        return redirect(route('admin.delivery.warehouses.index'));
    }
}
