<x-delivery::layouts.shipping>
    <div class="card">
        <div class="header">
            الطلبات
        </div>
        <hr />
        <div class="content">
            <div class="mb-4">
                <ul class="flex flex-wrap -mb-px text-center justify-evenly" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist"
                    data-tabs-active-classes="text-white border-gray-500"
                    data-tabs-inactive-classes="text-gray-500 border-gray-500 hover:border-white">

                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg sn-heading-3" id="pending-tab"
                            data-tabs-target="#pending" type="button" role="tab" aria-controls="pending"
                            aria-selected="false"> بانتظار تعيين سائق
                            @if ($pendingOrders->count() > 0)
                                ({{ $pendingOrders->count() }})
                            @endif
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg sn-heading-3" id="cancelled-tab"
                            data-tabs-target="#cancelled" type="button" role="tab" aria-controls="cancelled"
                            aria-selected="false"> يتم التوصيل
                            @if ($shippingOrders->count() > 0)
                                ({{ $shippingOrders->count() }})
                            @endif
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg sn-heading-3" id="done-tab"
                            data-tabs-target="#done" type="button" role="tab" aria-controls="done"
                            aria-selected="false"> تم التوصيل
                            @if ($completeOrders->count() > 0)
                                ({{ $completeOrders->count() }})
                            @endif
                        </button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class="flex mt-8 gap-4 max-lg:flex-col items-center flex-wrap">
                        @foreach ($pendingOrders as $order)
                            <a href="{{ route('shipping.orders.show', $order->id) }}" class="order-card">
                                <div class="sn-heading-3 text-center">
                                    {{ $order->shipping_details['date'] }}
                                </div>
                                <div class="sn-heading-3 text-center mb-5">
                                    {{ $order->shipping_details['time'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> مناطق التجار: </strong>
                                    {{ $order->shipping_details['address']['pickup_areas'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong>اسم المسلتم:</strong>
                                    {{ $order->shipping_details['address']['customer_name'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> رقم المستلم: </strong>
                                    {{ $order->shipping_details['address']['number'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> عنوان المستلم: </strong>
                                    {{ $order->shipping_details['address']['details'] }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="hidden" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                    <div class="flex mt-8 gap-4 max-lg:flex-col items-center flex-wrap">
                        @foreach ($shippingOrders as $order)
                            <a href="{{ route('shipping.orders.show', $order->id) }}" class="order-card">
                                <div class="sn-heading-3 text-center">
                                    {{ $order->shipping_details['date'] }}
                                </div>
                                <div class="sn-heading-3 text-center mb-5">
                                    {{ $order->shipping_details['time'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> مناطق التجار: </strong>
                                    {{ $order->shipping_details['address']['pickup_areas'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong>اسم المسلتم:</strong>
                                    {{ $order->shipping_details['address']['customer_name'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> رقم المستلم: </strong>
                                    {{ $order->shipping_details['address']['number'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> عنوان المستلم: </strong>
                                    {{ $order->shipping_details['address']['details'] }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="hidden" id="done" role="tabpanel" aria-labelledby="done-tab">
                    <div class="flex mt-8 gap-4 max-lg:flex-col items-center flex-wrap">
                        @foreach ($completeOrders as $order)
                            <a href="{{ route('shipping.orders.show', $order->id) }}" class="order-card">
                                <div class="sn-heading-3 text-center">
                                    {{ $order->shipping_details['date'] }}
                                </div>
                                <div class="sn-heading-3 text-center mb-5">
                                    {{ $order->shipping_details['time'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> مناطق التجار: </strong>
                                    {{ $order->shipping_details['address']['pickup_areas'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong>اسم المسلتم:</strong>
                                    {{ $order->shipping_details['address']['customer_name'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> رقم المستلم: </strong>
                                    {{ $order->shipping_details['address']['number'] }}
                                </div>
                                <div class="sn-body-1 text-ellipsis w-full overflow-hidden whitespace-nowrap">
                                    <strong> عنوان المستلم: </strong>
                                    {{ $order->shipping_details['address']['details'] }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-delivery::layouts.shipping>
