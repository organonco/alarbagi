<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Organon\Delivery\DataGrids\ShippingCompanyDataGrid;
use Organon\Delivery\Models\Area;
use Organon\Delivery\Models\ShippingCompany;

class ShippingCompanyController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        if (request()->ajax())
            return app(ShippingCompanyDataGrid::class)->toJson();
        return view("delivery::admin.shipping-company.index");
    }

    public function create()
    {
        return view('delivery::admin.shipping-company.create', ['areas' => Area::query()->whereDoesntHave('shippingCompany')->pluck('name', 'id')]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'password' => 'required|min:8',
            'username' => 'required|unique:shipping_companies',
        ]);

        $data = request()->all();
        $data['is_active'] = (bool)request()->input('is_active');
        $data['password'] = bcrypt($data['password']);

        ShippingCompany::create($data);

        return redirect()->route('admin.delivery.shipping-company.index');
    }


    public function edit($id)
    {
        $model = ShippingCompany::findOrFail($id);
        $areas = Area::query()->whereDoesntHave('shippingCompany')->orWhere('id', $model->area_id)->pluck('name', 'id');
        return view('delivery::admin.shipping-company.edit', ['shippingCompany' => $model, 'areas' => $areas]);
    }

    public function update($id)
    {
       
        $shippingCompany = ShippingCompany::findOrFail($id);

        request()->validate([
            'name' => 'required',
            'username' => [
                'required',
                Rule::unique('shipping_companies')->ignore($id),
            ]
        ]);

        $data = request()->all();
        $data['is_active'] = (bool)request()->input('is_active');
        if($data['password'] == "")
            unset($data['password']);
        else
            $data['password'] = bcrypt($data['password']);
        

        $shippingCompany->update($data);

        return redirect()->route('admin.delivery.shipping-company.index');
    }
}
