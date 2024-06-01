<?php

namespace Organon\Delivery\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Organon\Marketplace\Traits\InteractsWithAuthenticatedAdmin;


class TripController extends Controller
{
    use InteractsWithAuthenticatedAdmin;

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view('delivery::admin.trips.index');
    }

    public function create(Request $request)
    {
        return view('delivery::admin.trips.create');
    }
    public function store(Request $request)
    {
    }
}
