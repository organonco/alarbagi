<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Organon\Delivery\DataGrids\AreaDataGrid;
use Organon\Delivery\Models\Area;

class DeliveryController extends Controller
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
        if(request()->ajax())
            return app(AreaDataGrid::class)->toJson();
        return view("delivery::admin.area.index");
    }

    public function create()
    {
        return view('delivery::admin.area.create');
    }

    public function store()
    {
        request()->validate([
            'info' => 'required',
            'name' => 'required'
        ]);

        $data = request()->all();
        $data['is_active'] = request()->input('is_active') == 'on' ? true : false;

        Area::create($data);

        return redirect()->route('admin.delivery.area.index');
    }


    public function 

}
