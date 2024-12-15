<?php

namespace Webkul\Shop\Http\Controllers\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use Organon\Delivery\Models\Area;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Shop\Http\Requests\Customer\AddressRequest;
use Webkul\Shop\Http\Resources\AddressResource;

class AddressController extends APIController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CustomerAddressRepository $customerAddressRepository)
    {
    }

    /**
     * Customer addresses.
     */
    public function index(): JsonResource
    {
        $customer = auth()->guard('customer')->user();

        return AddressResource::collection($customer->addresses);
    }

    /**
     * Create a new address for customer.
     */
    public function store(AddressRequest $request): JsonResource
    {
        $customer = auth()->guard('customer')->user();

        $data = array_merge(request()->only([
            'name',
            'phone',
            'address_details',
            'area_id',
            'default_address',
            'lat',
            'lng'
        ]), [
            'customer_id'     => $customer->id,
        ]);

        $customerAddress = $this->customerAddressRepository->create($data);

        return new JsonResource([
            'message' => trans('shop::app.customers.account.addresses.create-success'),
        ]);
    }

    public function getAreas()
    {
        return Area::query()->isActive()->get();
    }
}
