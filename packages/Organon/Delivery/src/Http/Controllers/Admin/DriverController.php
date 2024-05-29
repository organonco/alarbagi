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
            return app(DriversDataGrid::class)->toJson();
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

        $driver = Driver::create(
            array_merge(
                $request->all(),
                [
                    'password' => Hash::make($request->input('password'))
                ]
            )
        );

        return redirect(route('admin.delivery.drivers.index'));
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('delivery::admin.drivers.edit', compact('driver'));
    }

    public function update($id, Request $request)
    {
        $driver = Driver::findOrFail($id);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:drivers,email,' . $driver->id,
            'phone' => 'required|max:255|regex:/^\+?[0-9]*$/',
        ]);
        $driver->update($request->all());
        return redirect(route('admin.delivery.drivers.index'));
    }


    public function updatePassword($id, Request $request)
    {
        $driver = Driver::findOrFail($id);
        $request->validate([
            'password' => "required|confirmed"
        ]);
        $driver->update(['password' => Hash::make($request->input('password'))]);
        return redirect(route('admin.delivery.drivers.index'));
    }
}
