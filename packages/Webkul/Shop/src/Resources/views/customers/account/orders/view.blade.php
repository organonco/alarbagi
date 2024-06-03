<x-shop::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.account.orders.view.page-title', ['order_id' => $order->increment_id])
    </x-slot:title>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="orders.view" :entity="$order"></x-shop::breadcrumbs>
    @endSection

    <div class="flex justify-between items-center">
        <div class="">
            <h2 class="text-[26px] font-medium">
                {{ core()->formatDate($order->created_at, 'd M Y') }}
            </h2>
        </div>

        @if ($order->canCancel())
            <form method="POST" ref="cancelOrderForm"
                action="{{ route('shop.customers.account.orders.cancel', $order->id) }}">
                @csrf
            </form>

            <a class="sn-button-secondary" href="javascript:void(0);"
                @click="$emitter.emit('open-confirm-modal', {
                    message: '@lang('shop::app.customers.account.orders.view.cancel-confirm-msg')',

                    agree: () => {
                        this.$refs['cancelOrderForm'].submit()
                    }
                })">
                @lang('shop::app.customers.account.orders.view.cancel-btn-title')
            </a>
        @endif
    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.view.before', ['order' => $order]) !!}

    {{-- Order view tabs --}}
    <div>

        <div class="relative overflow-x-auto mt-[30px] border rounded-[12px]">
            <table class="w-full text-sm text-left ">
                <thead class="bg-[#F5F5F5] border-b-[1px] border-[#E9E9E9] text-[14px] text-black">
                    <tr>

                        <th scope="col" class="px-6 py-[16px] font-medium">
                            @lang('shop::app.customers.account.orders.view.information.product-name')
                        </th>

                        <th scope="col" class="px-6 py-[16px] font-medium">
                            @lang('shop::app.customers.account.orders.view.information.seller')
                        </th>


                        <th scope="col" class="px-6 py-[16px] font-medium">
                            @lang('shop::app.customers.account.orders.view.information.qty')
                        </th>


                        <th scope="col" class="px-6 py-[16px] font-medium">
                            @lang('shop::app.customers.account.orders.view.information.price')
                        </th>

                        <th scope="col" class="px-6 py-[16px] font-medium">
                            @lang('shop::app.customers.account.orders.view.information.subtotal')
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-[16px] text-black font-medium" data-value="@lang('shop::app.customers.account.orders.view.information.product-name')">
                                <a href="{{ route('shop.product_or_category.index', $item->product->url_key) }}"
                                    target="_blank">
                                    {{ $item->name }}

                                    @if (isset($item->additional['attributes']))
                                        <div>
                                            @foreach ($item->additional['attributes'] as $attribute)
                                                <b>{{ $attribute['attribute_name'] }} :
                                                </b>{{ $attribute['option_label'] }}<br>
                                            @endforeach
                                        </div>
                                    @endif
                                </a>
                            </td>
                            <td class="px-6 py-[16px] text-black font-medium" data-value="@lang('shop::app.customers.account.orders.view.information.price')">
                                {{ $item->product->seller_name }}
                            </td>


                            <td class="px-6 py-[16px] text-black font-medium" data-value="@lang('shop::app.customers.account.orders.view.information.price')">
                                {{ $item->qty_ordered }}
                            </td>

                            <td class="px-6 py-[16px] text-black font-medium" data-value="@lang('shop::app.customers.account.orders.view.information.price')">
                                {{ core()->formatPrice($item->price, $order->order_currency_code) }}
                            </td>

                            <td class="px-6 py-[16px] text-black font-medium" data-value="@lang('shop::app.customers.account.orders.view.information.subtotal')">
                                {{ core()->formatPrice($item->total, $order->order_currency_code) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex gap-[40px] items-start mt-[30px] max-lg:gap-[20px] max-md:grid">
            <div class="flex-auto max-md:mt-[30px]">
                <div class="flex justify-end">
                    <div class="grid gap-[8px] max-w-max">
                        <div class="flex gap-x-[20px] justify-between w-full">
                            <p class="text-[14px]">
                                @lang('shop::app.customers.account.orders.view.information.subtotal')
                            </p>

                            <div class="flex gap-x-[20px]">
                                <p class="text-[14px]">-</p>

                                <p class="text-[14px]">
                                    {{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}
                                </p>
                            </div>
                        </div>

                        @if ($order->haveStockableItems())
                            <div class="flex w-full gap-x-[20px] justify-between">
                                <p class="text-[14px]">
                                    @lang('shop::app.customers.account.orders.view.information.shipping-handling')
                                </p>

                                <div class="flex gap-x-[20px]">
                                    <p class="text-[14px]">-</p>

                                    <p class="text-[14px]">
                                        {{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($order->base_discount_amount > 0)
                            <div class="flex gap-x-[20px] justify-between w-full">
                                <p class="text-[14px]">
                                    @lang('shop::app.customers.account.orders.view.information.discount')

                                    @if ($order->coupon_code)
                                        ({{ $order->coupon_code }})
                                    @endif
                                </p>

                                <div class="flex gap-x-[20px]">
                                    <p class="text-[14px]">-</p>

                                    <p class="text-[14px]">
                                        {{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}
                                    </p>
                                </div>
                            </div>
                        @endif


                        <div class="flex gap-x-[20px] justify-between w-full">
                            <p class="text-[14px]">
                                @lang('shop::app.customers.account.orders.view.information.grand-total')
                            </p>

                            <div class="flex gap-x-[20px]">
                                <p class="text-[14px]">-</p>

                                <p class="text-[14px]">
                                    {{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}
                                </p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


        <div
            class="flex flex-wrap gap-x-[64px] gap-y-[30px] justify-between mt-[42px] pt-[26px] border-t-[1px] border-[#E9E9E9]">
            {{-- Biiling Address --}}
            @if ($order->billing_address)
                <div
                    class="grid gap-[15px] max-w-[200px] max-868:w-full max-868:max-w-full max-md:max-w-[200px] max-sm:max-w-full">
                    <p class="text-[16px] text-[#6E6E6E]">
                        @lang('shop::app.customers.account.orders.view.billing-address')
                    </p>

                    <div class="grid gap-[10px]">
                        <p class="text-[14px]">
                            @include ('admin::sales.address', ['address' => $order->billing_address])
                        </p>

                        {!! view_render_event('bagisto.shop.customers.account.orders.view.billing_address.after', ['order' => $order]) !!}
                    </div>
                </div>
            @endif

            {{-- Shipping Address --}}
            @if ($order->shipping_address)
                <div
                    class="grid gap-[15px] max-w-[200px] max-868:w-full max-868:max-w-full max-md:max-w-[200px] max-sm:max-w-full">
                    <p class="text-[16px] text-[#6E6E6E]">
                        @lang('shop::app.customers.account.orders.view.shipping-address')
                    </p>

                    <div class="grid gap-[10px]">
                        <p class="text-[14px]">
                            @include ('admin::sales.address', ['address' => $order->shipping_address])

                            {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping_address.after', ['order' => $order]) !!}
                        </p>
                    </div>
                </div>

                {{-- Shipping Method --}}
                <div
                    class="grid gap-[15px] max-w-[200px] place-content-baseline max-868:w-full max-868:max-w-full max-md:max-w-[200px] max-sm:max-w-full">
                    <p class="text-[16px] text-[#6E6E6E]">
                        @lang('shop::app.customers.account.orders.view.shipping-method')
                    </p>

                    <p class="text-[14px]">
                        {{ $order->shipping_title }}
                    </p>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.orders.view.shipping_method.after', ['order' => $order]) !!}
            @endif

            {{-- Billing Method --}}
            <div
                class="grid gap-[15px] place-content-baseline max-w-[200px] max-868:w-full max-868:max-w-full max-md:max-w-[200px] max-sm:max-w-full">
                <p class="text-[16px] text-[#6E6E6E]">
                    @lang('shop::app.customers.account.orders.view.payment-method')
                </p>

                <p class="text-[14px]">
                    {{ core()->getConfigData('sales.payment_methods.' . $order->payment->method . '.title') }}
                </p>

                @if (!empty($additionalDetails))
                    <div class="instructions">
                        <label>{{ $additionalDetails['title'] }}</label>
                    </div>
                @endif

                {!! view_render_event('bagisto.shop.customers.account.orders.view.payment_method.after', ['order' => $order]) !!}
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.view.after', ['order' => $order]) !!}
</x-shop::layouts.account>
