<div class="flex flex-col">

    <p class="text-gray-800 font-semibold leading-6 dark:text-white">
        {{ $method }}
    </p>
    <p class="text-gray-600 dark:text-gray-300 leading-6">
        {{ __('admin::app.sales.orders.view.name') }} : {{ $address->name }} <br />
        {{ __('admin::app.sales.orders.view.contact') }} : {{ $address->phone }} <br />
        @if (!$isPickup)
        {{ __('admin::app.sales.orders.view.area') }} : {{ $address->area_name }}<br>
        {{ __('admin::app.sales.orders.view.details') }} : {{ $address->address_details }}<br>
            @if($address->area->is_shippable)
            {{ __('admin::app.sales.orders.view.shipping-company') }} : {{ $address->area->shippingCompany->name }}<br>
            @endif
        @endif
    </p>
</div>
