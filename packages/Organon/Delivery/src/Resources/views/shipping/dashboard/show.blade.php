<x-delivery::layouts.shipping>
    @if ($order->status == 'approved' || $order->status == 'partially-approved')
        <form method="POST" action="{{ route('shipping.orders.mark-as-shipping', $order->id) }}">
            @csrf
            @method('PUT')
            <button class="button-primary sn-heading-3"> تغيير حالة الطلب لـ "يتم التوصيل"</button>
        </form>
        <div class="card">
            <div class="header">
                إبلاغ سائق
            </div>
            <hr />
            <div class="description">
            </div>
            <div class="content">
                <div class="input flex gap-4 items-center content-center justify-center">
                    <select id="select">
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->phone }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                    <button id="send" class="button-primary sn-heading-3">إبلاغ</button>
                </div>
            </div>
        </div>
    @endif

    @if ($order->status == 'shipping')
        <form method="POST" action="{{ route('shipping.orders.mark-as-complete', $order->id) }}">
            @csrf
            @method('PUT')
            <button class="button-primary sn-heading-3"> تغيير حالة الطلب لـ "مكتمل" (تم التوصيل)</button>
        </form>
    @endif

    <div class="card">
        <div class="header">
            معلومات الطلب - @lang('marketplace::app.order.statuses.' . $order->status . '.label')
        </div>
        <div class="description">
            {{ $order->shipping_details['time'] }} - {{ $order->shipping_details['date'] }}
        </div>
        <hr />
        <div class="content">
            <div class="data">
                <ul>
                    @foreach ($order->sellerOrders()->where('status', 'approved')->get()->where('is_deliverable', true) as $sellerOrder)
                        <li>
                            <div class="overflow-auto">
                                <table class="invoice-table lg:w-full">
                                    <tr>
                                        <td class="sn-heading-3" colspan="4">
                                            {{ $sellerOrder->seller->name }} -
                                            {{ $sellerOrder->seller->area->name }} -
                                            شارع {{ $sellerOrder->seller->street }} -
                                            طابق {{ $sellerOrder->seller->floor }} -
                                            بناء {{ $sellerOrder->seller->building }} -
                                            <a class="sn-heading-3 underline"
                                                href="tel:{{ $sellerOrder->seller->phone }}">{{ $sellerOrder->seller->phone }}</a> <br/>
                                            <a href="{{"https://maps.google.com/?q=" . $sellerOrder->seller->lat . ',' . $sellerOrder->seller->lng}}" class="sn-heading-3 underline" target="_blank"> فتح العنوان على الخريطة </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sn-heading-3">
                                            المنتج
                                        </td>
                                        <td class="sn-heading-3">
                                            الكمية
                                        </td>
                                        <td class="sn-heading-3">
                                            سعر القطعة
                                        </td>
                                        <td class="sn-heading-3">
                                            المجموع
                                        </td>
                                    </tr>
                                    @foreach ($sellerOrder->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->qty_ordered }}</td>
                                            <td>{{ (int) $item->base_price }} ل.س</td>
                                            <td>{{ (int) $item->total }} ل.س</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="sn-heading-3" colspan="3">المجموع الفرعي </td>
                                        <td class="sn-heading-3">{{ (int) $sellerOrder->subtotal }} ل.س</td>
                                    </tr>
                                </table>
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="header">
            معلومات التوصيل
        </div>
        <hr />
        <div class="content">
            <div class="sn-heading-3">
                اسم المستلم: {{ $order->shipping_address->name }}
            </div>
            <div class="sn-heading-3">
                رقم الهاتف: {{ $order->shipping_address->phone }}
            </div>
            <div class="sn-heading-3">
                شارع: {{ $order->shipping_address->street }}
            </div>
            <div class="sn-heading-3">
                بناء: {{ $order->shipping_address->building }}
            </div>
            <div class="sn-heading-3">
                طابق: {{ $order->shipping_address->floor }}
            </div>
            <div class="sn-heading-3">
                تفاصيل العنوان: {{ $order->shipping_address->area->name }} - {{ $order->shipping_address->address_details }}
            </div>
            <a href="{{"https://maps.google.com/?q=" . $order->shipping_address->lat . ',' . $order->shipping_address->lng}}" class="sn-heading-3 underline" target="_blank"> فتح العنوان على الخريطة </a>
        </div>
    </div>

    <div class="card">
        <div class="header">
            معلومات الدفع
        </div>
        <hr />
        <div class="content">
            <div class="sn-body-1 mb-4">
                <strong> طريقة الدفع: </strong>
                {{ $order->payment->method == 'cashondelivery' ? 'يقوم الزبون بدفع المجموع الكلي عند الاستلام' : 'تم الدفع بشكل الكتروني الى حساب البنك' }}
            </div>

            <div class="sn-body-1 mb-4">
                <strong>الفاتورة</strong>
            </div>

            <div class="overflow-auto">
                <table class="invoice-table lg:w-full">
                    <tr>
                        <td class="sn-heading-3">
                            المنتج
                        </td>
                        <td class="sn-heading-3">
                            الكمية
                        </td>
                        <td class="sn-heading-3">
                            سعر القطعة
                        </td>
                        <td class="sn-heading-3">
                            المجموع
                        </td>
                    </tr>
                    @foreach ($order->approvedItems->where('is_deliverable', true) as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->qty_ordered }}</td>
                            <td>{{ (int) $item->base_price }} ل.س</td>
                            <td>{{ (int) $item->total }} ل.س</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td class="sn-heading-3" colspan="3">المجموع الفرعي</td>
                        <td class="sn-heading-3">{{ (int) $order->deliverable_total }} ل.س</td>
                    </tr>

                    <tr>
                        <td class="sn-heading-3" colspan="3">أجور التوصيل</td>
                        <td class="sn-heading-3">
                            @if ((int) $order->shipping_amount > 0)
                                {{ (int) $order->shipping_invoiced }} ل.س
                            @else
                                غير محددة
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <td class="sn-heading-3" colspan="3">المجموع الكلي</td>
                        <td class="sn-heading-3">{{ (int) $order->deliverable_total + $order->shipping_invoiced }} ل.س
                        </td>
                    </tr>


                </table>
            </div>
            <div class="sn-body-1">
            </div>
        </div>
    </div>

    @pushonce('scripts')
        <script>
            document.getElementById("send").onclick = () => {
                let url = "https://wa.me/" + document.getElementById("select").value + "?text=مرحباً%20"
                window.open(url, '_blank').focus();
            }
        </script>
    @endpushonce
</x-delivery::layouts.shipping>
