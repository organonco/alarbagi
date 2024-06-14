<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.sales.orders.view.title', ['order_id' => $order->increment_id])
    </x-slot:title>

    {{-- Header --}}
    <div class="grid">
        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            {!! view_render_event('sales.order.title.before', ['order' => $order]) !!}
            <div class="flex gap-[10px] items-center">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold leading-[24px]">
                    @lang('admin::app.sales.orders.view.title', ['order_id' => $order->increment_id])
                </p>

                <div>
                    @switch($order->status)
                        @case('processing')
                            <span class="label-processing text-[14px] mx-[5px]">
                                @lang('admin::app.sales.orders.view.processing')
                            </span>
                            @break

                        @case('completed')
                            <span class="label-closed text-[14px] mx-[5px]">
                                @lang('admin::app.sales.orders.view.completed')
                            </span>
                            @break

                        @case('pending')
                            <span class="label-pending text-[14px] mx-[5px]">
                                @lang('admin::app.sales.orders.view.pending')
                            </span>
                            @break

                        @case('closed')
                            <span class="label-closed text-[14px] mx-[5px]">
                                @lang('admin::app.sales.orders.view.closed')
                            </span>
                            @break

                        @case('canceled')
                            <span class="label-cancelled text-[14px] mx-[5px]">
                                @lang('admin::app.sales.orders.view.canceled')
                            </span>
                            @break

                    @endswitch
                </div>
            </div>

            {!! view_render_event('sales.order.title.after', ['order' => $order]) !!}

            {{-- Back Button --}}
            <a
                    href="{{ route('admin.sales.orders.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
            >
                @lang('admin::app.account.edit.back-btn')
            </a>
        </div>
    </div>

    <div class="justify-between gap-x-[4px] gap-y-[8px] items-center flex-wrap mt-[20px]">
        <div class="flex gap-[5px]">
            {!! view_render_event('sales.order.page_action.before', ['order' => $order]) !!}

            @if (
                $order->canCancel()
                && bouncer()->hasPermission('sales.orders.cancel')
            )
                <form
                        method="POST"
                        ref="cancelOrderForm"
                        action="{{ route('admin.sales.orders.cancel', $order->id) }}"
                >
                    @csrf
                </form>

                <div
                        class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                        @click="$emitter.emit('open-confirm-modal', {
                        message: '@lang('shop::app.customers.account.orders.view.cancel-confirm-msg')',
                        agree: () => {
                            this.$refs['cancelOrderForm'].submit()
                        }
                    })"
                >
                    <span class="icon-cancel text-[24px]"></span>

                    <a
                            href="javascript:void(0);"
                    >
                        @lang('admin::app.sales.orders.view.cancel')
                    </a>
                </div>
            @endif

            @if (
                $order->canInvoice()
                && $order->payment->method !== 'paypal_standard'
            )

                @include('admin::sales.invoices.create')
            @endif

            @if ($order->canShip())
                @include('admin::sales.shipments.create')
            @endif

            @if ($order->canRefund())
                @include('admin::sales.refunds.create')
            @endif

            {!! view_render_event('sales.order.page_action.after', ['order' => $order]) !!}
        </div>

        {{-- Order details --}}
        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            {{-- Left Component --}}
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="flex justify-between p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[16px]">
                            @lang('المنتجات') ({{ count($order->items) }})
                        </p>

                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                            @lang('admin::app.sales.orders.view.grand-total', ['grand_total' => core()->formatBasePrice($order->base_grand_total)])
                        </p>
                    </div>

                    {{-- Order items --}}
                    <div class="grid">
                        @foreach ($order->items as $item)
                            <div class="flex gap-[10px] justify-between px-[16px] py-[24px] border-b-[1px] border-slate-300 dark:border-gray-800">
                                <div class="flex gap-[10px]">
                                    @if($item->product?->base_image_url)
                                        <img
                                                class="w-full h-[60px] max-w-[60px] max-h-[60px] relative rounded-[4px]"
                                                src="{{ $item->product?->base_image_url }}"
                                        >
                                    @else
                                        <div class="w-full h-[60px] max-w-[60px] max-h-[60px] relative border border-dashed border-gray-300 dark:border-gray-800 rounded-[4px] dark:invert dark:mix-blend-exclusion">
                                            <img src="{{ bagisto_asset('images/product-placeholders/front.svg') }}">

                                            <p class="absolute w-full bottom-[5px] text-[6px] text-gray-400 text-center font-semibold">
                                                @lang('admin::app.sales.invoices.view.product-image')
                                            </p>
                                        </div>
                                    @endif

                                    <div class="grid gap-[6px] place-content-start">
                                        <p class="text-[16x] text-gray-800 dark:text-white font-semibold">
                                            {{ $item->name }}
                                        </p>

                                        <div class="flex flex-col gap-[6px] place-items-start">
                                            <p class="text-gray-600 dark:text-gray-300">
                                                @lang('admin::app.sales.orders.view.amount-per-unit', [
                                                    'amount' => core()->formatBasePrice($item->base_price),
                                                    'qty'    => $item->qty_ordered,
                                                    ])
                                            </p>

                                            @if (isset($item->additional['attributes']))
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    @foreach ($item->additional['attributes'] as $attribute)
                                                        {{ $attribute['attribute_name'] }}
                                                        : {{ $attribute['option_label'] }}
                                                    @endforeach
                                                </p>
                                            @endif

                                            <p class="text-gray-600 dark:text-gray-300">
                                                @lang('admin::app.sales.orders.view.sku', ['sku' => $item->sku])
                                            </p>

{{--                                            <p class="text-gray-600 dark:text-gray-300">--}}
{{--                                                {{ $item->qty_ordered ? trans('admin::app.sales.orders.view.item-ordered', ['qty_ordered' => $item->qty_ordered]) : '' }}--}}

{{--                                                {{ $item->qty_invoiced ? trans('admin::app.sales.orders.view.item-invoice', ['qty_invoiced' => $item->qty_invoiced]) : '' }}--}}

{{--                                                {{ $item->qty_shipped ? trans('admin::app.sales.orders.view.item-shipped', ['qty_shipped' => $item->qty_shipped]) : '' }}--}}

{{--                                                {{ $item->qty_refunded ? trans('admin::app.sales.orders.view.item-refunded', ['qty_refunded' => $item->qty_refunded]) : '' }}--}}

{{--                                                {{ $item->qty_canceled ? trans('admin::app.sales.orders.view.item-canceled', ['qty_canceled' => $item->qty_canceled]) : '' }}--}}
{{--                                            </p>--}}
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-[4px] place-content-start">
                                    <div class="">
                                        <p class="flex items-center gap-x-[4px] justify-end text-[16px] text-gray-800 dark:text-white font-semibold">
                                            {{ core()->formatBasePrice($item->base_total) }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-[6px] items-end place-items-start">
                                        <p class="text-gray-600 dark:text-gray-300">
                                            @lang('admin::app.sales.orders.view.price', ['price' => core()->formatBasePrice($item->base_price)])
                                        </p>

                                        <p class="text-gray-600 dark:text-gray-300">
                                            @lang('admin::app.sales.orders.view.sub-total', ['sub_total' => core()->formatBasePrice($item->base_total)])
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="flex w-full gap-[10px] justify-end mt-[16px] p-[16px]">
                        <div class="flex flex-col gap-y-[6px]">
                            <p class="text-gray-600 dark:text-gray-300  font-semibold">
                                @lang('admin::app.sales.orders.view.summary-sub-total')
                            </p>


                            @if ($haveStockableItems = $order->haveStockableItems())
                                <p class="text-gray-600 dark:text-gray-300">
                                    @lang('admin::app.sales.orders.view.shipping-and-handling')</p>
                            @endif

                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                                @lang('admin::app.sales.orders.view.summary-grand-total')
                            </p>

                        </div>
                        <div class="flex  flex-col gap-y-[6px]">
                            <p class="text-gray-600 dark:text-gray-300  font-semibold">
                                {{ core()->formatBasePrice($order->base_sub_total) }}
                            </p>

                            @if ($haveStockableItems)
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ core()->formatBasePrice($order->base_shipping_amount) }}
                                </p>
                            @endif

                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                                {{ core()->formatBasePrice($order->base_grand_total) }}
                            </p>

{{--                            <p class="text-gray-600 dark:text-gray-300">--}}
{{--                                {{ core()->formatBasePrice($order->base_grand_total_invoiced) }}--}}
{{--                            </p>--}}

{{--                            <p class="text-gray-600 dark:text-gray-300">--}}
{{--                                {{ core()->formatBasePrice($order->base_grand_total_refunded) }}--}}
{{--                            </p>--}}

{{--                            @if($order->status !== 'canceled')--}}
{{--                                <p class="text-gray-600 dark:text-gray-300">--}}
{{--                                    {{ core()->formatBasePrice($order->base_total_due) }}--}}
{{--                                </p>--}}
{{--                            @else--}}
{{--                                <p class="text-gray-600 dark:text-gray-300">--}}
{{--                                    {{ core()->formatBasePrice(0.00) }}--}}
{{--                                </p>--}}
{{--                            @endif--}}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="flex justify-between p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[16px]">
                            الطلبات الفرعية ({{ count($order->sellerOrders) }})
                        </p>
                    </div>

                    {{-- Order items --}}
                    <div class="grid">
                        @foreach($order->sellerOrders as $seller_order)
                            <div class="flex gap-[10px] justify-between px-[16px] py-[24px] border-b-[1px] border-slate-300 dark:border-gray-800">
                                <div class="flex gap-[10px]">
                                    @if($seller_order->seller->logo_url)
                                        <img
                                                class="w-full h-[60px] max-w-[60px] max-h-[60px] relative rounded-[4px]"
                                                src="{{ $seller_order->seller->logo_url }}"
                                        >
                                    @endif
                                    <div class="grid gap-[6px] place-content-start">
                                        <p class="text-[16x] text-gray-800 dark:text-white font-semibold">
                                            {{ $seller_order->seller->name }}
                                        </p>

                                        <div class="flex flex-col gap-[6px] place-items-start">
                                            <p class="text-gray-600 dark:text-gray-300">
                                                {{$seller_order->seller->address}}
                                            </p>

                                            <span class="label-{{trans('marketplace::app.seller-order.statuses.' . $seller_order->status->name . '.class')}} text-[14px] mx-[5px]">
                                                @lang('marketplace::app.seller-order.statuses.' . $seller_order->status->name . '.label')
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-[4px] place-content-start">
                                    <div class="flex flex-col gap-[6px] items-end place-items-start">
                                        <p class="text-gray-600 dark:text-gray-300">
                                            @lang('admin::app.sales.orders.view.sub-total', ['sub_total' => core()->formatBasePrice($seller_order->subtotal)])
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {!! view_render_event('sales.order.tabs.before', ['order' => $order]) !!}

            {{-- Right Component --}}
            <div class="flex flex-col gap-[8px] w-[360px] max-w-full max-sm:w-full">
                {{-- Customer and address information --}}
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="text-gray-600 dark:text-gray-300 text-[16px] p-[10px] font-semibold">
                            @lang('admin::app.sales.orders.view.customer')
                        </p>
                    </x-slot:header>

                    <x-slot:content>
                        <div class="{{ $order->billing_address ? 'pb-[16px]' : '' }}">
                            <div class="flex flex-col gap-[5px]">
                                <p class="text-gray-800 font-semibold dark:text-white">
                                    {{ $order->customer_full_name }}
                                </p>

                                {!! view_render_event('sales.order.customer_full_name.after', ['order' => $order]) !!}

                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ $order->customer_email }}
                                </p>

                                {!! view_render_event('sales.order.customer_email.after', ['order' => $order]) !!}
                            </div>
                        </div>

                        {{-- Shipping Address --}}
                        @if ($order->shipping_address)
                            <span class="block w-full border-b-[1px] dark:border-gray-800"></span>

                            <div class="flex items-center justify-between">
                                <p class="text-gray-600 dark:text-gray-300 text-[16px] py-[16px] font-semibold">
                                    @lang('admin::app.sales.orders.view.shipping-address')
                                </p>
                            </div>

                            @include ('admin::sales.address', ['address' => $order->shipping_address])

                            {!! view_render_event('sales.order.shipping_address.after', ['order' => $order]) !!}
                        @endif
                    </x-slot:content>
                </x-admin::accordion>

                {{-- Order Information --}}
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="text-gray-600 dark:text-gray-300 text-[16px] p-[10px] font-semibold">
                            @lang('admin::app.sales.orders.view.order-information')
                        </p>
                    </x-slot:header>

                    <x-slot:content>
                        <div class="flex w-full gap-[20px] justify-start">
                            <div class="flex flex-col gap-y-[6px]">
                                <p class="text-gray-600 dark:text-gray-300">
                                    @lang('admin::app.sales.orders.view.order-date')
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    @lang('admin::app.sales.orders.view.payment-method')
                                </p>
                            </div>

                            <div class="flex flex-col gap-y-[6px]">
                                {!! view_render_event('sales.order.created_at.before', ['order' => $order]) !!}

                                {{-- Order Date --}}
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{core()->formatDate($order->created_at) }}
                                </p>

                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ core()->getConfigData('sales.payment_methods.' . $order->payment->method . '.title') }}
                                </p>
                            </div>


                        </div>
                    </x-slot:content>
                </x-admin::accordion>

            </div>

            {!! view_render_event('sales.order.tabs.after', ['order' => $order]) !!}
        </div>
    </div>
</x-admin::layouts>
