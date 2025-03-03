<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Organon\Delivery\DataGrids\AreaDataGrid;
use Organon\Delivery\Models\Area;

class AreaController extends Controller
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
			'name' => 'required',
			'is_active' => 'sometimes|in:1',
			'is_visible' => 'sometimes|in:1',
			'sort' => 'required|numeric'
		]);

		$data = request()->all();
		$data['is_active'] = (bool)request()->input('is_active');
		$data['is_visible'] = (bool)request()->input('is_visible');

		/** @var Area */
		$area = Area::create($data);
		$area->addImage($data);
		return redirect()->route('admin.delivery.area.index');
	}


	public function edit($id)
	{
		return view('delivery::admin.area.edit', ['area' => Area::findOrFail($id)]);
	}

	public function update($id)
	{
		/** @var Area */
		$area = Area::findOrFail($id);

		request()->validate([
			'name' => 'required',
			'is_active' => 'sometimes|in:1',
			'is_visible' => 'sometimes|in:1',
			'sort' => 'required|numeric'
		]);

		$data = request()->all();
		$data['is_active'] = (bool)request()->input('is_active');
		$data['is_visible'] = (bool)request()->input('is_visible');

		$area->update($data);
		$area->updateImage($data);
		return redirect()->route('admin.delivery.area.index');
	}
}
