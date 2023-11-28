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
                    <span class="label-{{trans('marketplace::app.seller-order.statuses.'. $order->status->name . '.class')}} text-[14px] mx-[5px]">
                        @lang('marketplace::app.seller-order.statuses.'. $order->status->name . '.label')
                    </span>
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

            @if($order->isApprovable())
                <div class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                     @click="$emitter.emit('open-confirm-modal', {message: '@lang('marketplace::app.admin.orders.view.approve-msg')', agree: () => {this.$refs['approveOrderForm'].submit()}})">
                    <form method="POST" ref="approveOrderForm"
                          action="{{ route('marketplace.admin.orders.approve', $order->order_id) }}"> @csrf </form>
                    <span class="icon-tick text-[24px]"></span>
                    <a href="javascript:void(0);"> @lang('marketplace::app.admin.orders.view.approve')</a>
                </div>
            @endif
            @if($order->isCancellable())
                <div class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                     @click="$emitter.emit('open-confirm-modal', {message: '@lang('marketplace::app.admin.orders.view.cancel-msg')',agree: () => {this.$refs['cancelOrderForm'].submit()}})">
                    <form method="POST" ref="cancelOrderForm"
                          action="{{ route('marketplace.admin.orders.cancel', $order->order_id) }}">@csrf</form>
                    <span class="icon-cancel text-[24px]"></span>
                    <a href="javascript:void(0);">@lang('marketplace::app.admin.orders.view.cancel')</a>
                </div>
            @endif

        </div>

        {{-- Order details --}}
        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            {{-- Left Component --}}
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="flex justify-between p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[16px]">
                            @lang('Order Items') ({{ count($order->items) }})
                        </p>

                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                            @lang('admin::app.sales.orders.view.grand-total', ['grand_total' => core()->formatBasePrice($order->grand_total)])
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


                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-[4px] place-content-start">
                                    <div class="">
                                        <p class="flex items-center gap-x-[4px] justify-end text-[16px] text-gray-800 dark:text-white font-semibold">
                                            {{ core()->formatBasePrice($item->base_total + $item->base_tax_amount - $item->base_discount_amount) }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-[6px] items-end place-items-start">
                                        <p class="text-gray-600 dark:text-gray-300">
                                            @lang('admin::app.sales.orders.view.price', ['price' => core()->formatBasePrice($item->base_price)])
                                        </p>

                                        <p class="text-gray-600 dark:text-gray-300">
                                            {{ (float)$item->tax_percent }}%
                                            @lang('admin::app.sales.orders.view.tax', ['tax' => core()->formatBasePrice($item->base_tax_amount)])
                                        </p>
                                        @if ($order->base_discount_amount > 0)
                                            <p class="text-gray-600 dark:text-gray-300">
                                                @lang('admin::app.sales.orders.view.discount', ['discount' => core()->formatBasePrice($item->base_discount_amount)])
                                            </p>
                                        @endif

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

                            <p class="text-gray-600 dark:text-gray-300">
                                @lang('admin::app.sales.orders.view.summary-tax')
                            </p>

                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                                @lang('admin::app.sales.orders.view.summary-grand-total')
                            </p>

                        </div>
                        <div class="flex  flex-col gap-y-[6px]">
                            <p class="text-gray-600 dark:text-gray-300  font-semibold">
                                {{ core()->formatBasePrice($order->subtotal) }}
                            </p>

                            <p class="text-gray-600 dark:text-gray-300">
                                {{ core()->formatBasePrice($order->tax_amount) }}
                            </p>


                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                                {{ core()->formatBasePrice($order->grand_total) }}
                            </p>

                        </div>
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

                                {!! view_render_event('sales.order.customer_group.after', ['order' => $order]) !!}
                            </div>
                        </div>

                        {{-- Billing Address --}}
                        @if ($order->billing_address)
                            <span class="block w-full border-b-[1px] dark:border-gray-800"></span>

                            <div class="{{ $order->shipping_address ? 'pb-[16px]' : '' }}">

                                <div class="flex items-center justify-between">
                                    <p class="text-gray-600 dark:text-gray-300  text-[16px] py-[16px] font-semibold">
                                        @lang('admin::app.sales.orders.view.billing-address')
                                    </p>
                                </div>

                                @include ('admin::sales.address', ['address' => $order->billing_address])

                                {!! view_render_event('sales.order.billing_address.after', ['order' => $order]) !!}
                            </div>
                        @endif

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
                                    @lang('admin::app.sales.orders.view.order-status')
                                </p>

                            </div>

                            <div class="flex flex-col gap-y-[6px]">
                                {!! view_render_event('sales.order.created_at.before', ['order' => $order]) !!}

                                {{-- Order Date --}}
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{core()->formatDate($order->created_at) }}
                                </p>

                                {!! view_render_event('sales.order.created_at.after', ['order' => $order]) !!}

                                {{-- Order Status --}}
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{$order->status->value}}
                                </p>

                                {!! view_render_event('sales.order.status_label.after', ['order' => $order]) !!}

                                {!! view_render_event('sales.order.channel_name.after', ['order' => $order]) !!}
                            </div>
                        </div>
                    </x-slot:content>
                </x-admin::accordion>

            </div>

            {!! view_render_event('sales.order.tabs.after', ['order' => $order]) !!}
        </div>
    </div>
</x-admin::layouts>