<x-admin::layouts>
    <x-slot:title>
        Sellers
    </x-slot:title>

    @push('styles')
        <style>
            .info-table {
                width: 100%;
                border-top: 1px solid #aaaaaa;
            }

            .info-table td {
                padding: 10px;
                border-bottom: 1px solid #aaaaaa;
            }

            .border-left {
                border-left: 1px solid #aaaaaa;
            }
        </style>
    @endpush

    {{-- Header --}}
    <div class="grid">
        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <div class="flex gap-[10px] items-center">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold leading-[24px]">
                    {{$seller->name}}
                    ({{$seller->is_personal ? trans('marketplace::app.seller.is_personal.true') : trans('marketplace::app.seller.is_personal.false')}}
                    )
                </p>

                <div>
                    <span
                        class="label-{{trans('marketplace::app.seller.statuses.'. $seller->status->name . '.class')}} text-[14px] mx-[5px]">
                        @lang('marketplace::app.seller.statuses.'. $seller->status->name . '.label')
                    </span>
                </div>
            </div>

            <a
                href="{{ route('admin.sales.sellers.index') }}"
                class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
            >
                @lang('admin::app.account.edit.back-btn')
            </a>
        </div>
    </div>

    <div class="justify-between gap-x-[4px] gap-y-[8px] items-center flex-wrap mt-[20px]">
        <div class="flex gap-[5px]">

            @if($seller->isActivatable())
                <div
                    class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                    @click="$emitter.emit('open-confirm-modal', {message: '@lang('marketplace::app.admin.sellers.view.activate-msg')', agree: () => {this.$refs['activateForm'].submit()}})">
                    <form method="POST" ref="activateForm"
                          action="{{ route('admin.sales.sellers.activate', $seller->id) }}"> @csrf </form>
                    <span class="icon-tick text-[24px]"></span>
                    <a href="javascript:void(0);"> @lang('marketplace::app.admin.sellers.view.activate')</a>
                </div>
            @endif
            @if($seller->isDeactivatable())
                <div
                    class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                    @click="$emitter.emit('open-confirm-modal', {message: '@lang('marketplace::app.admin.sellers.view.deactivate-msg')',agree: () => {this.$refs['deactivateForm'].submit()}})">
                    <form method="POST" ref="deactivateForm"
                          action="{{ route('admin.sales.sellers.deactivate', $seller->id) }}">@csrf</form>
                    <span class="icon-cancel text-[24px]"></span>
                    <a href="javascript:void(0);">@lang('marketplace::app.admin.sellers.view.deactivate')</a>
                </div>
            @endif

            @if($seller->hasDraftInvoice())
                <div
                    class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]">
                    <span class="icon-calendar text-[24px]"></span>
                    <a href="{{route('admin.sales.sellers.invoice.view', ['invoice_id' => $seller->getDraftInvoiceId()])}}">@lang('marketplace::app.admin.sellers.view.edit-invoice')</a>
                </div>
            @else
                <div
                    class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                    @click="$emitter.emit('open-confirm-modal', {message: '@lang('marketplace::app.admin.sellers.view.generate-invoice-msg')',agree: () => {this.$refs['generateInvoiceForm'].submit()}})">
                    <form method="POST" ref="generateInvoiceForm"
                          action="{{ route('admin.sales.sellers.invoice.generate', $seller->id) }}">@csrf</form>
                    <span class="icon-calendar text-[24px]"></span>
                    <a href="javascript:void(0);">@lang('marketplace::app.admin.sellers.view.generate-invoice')</a>
                </div>
            @endif

        </div>

        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            Shop Info
                        </p>
                        <div class="info-box text-gray-800 dark:text-white">
                            <table class="info-table">
                                @foreach(['name','description','address','slug','payment_method','deliver_by'] as $key)
                                    <tr class="info-table">
                                        <td>
                                            @lang('marketplace::app.admin.account.profile.labels.' . $key)
                                        </td>
                                        <td class="border-left text-center">
                                            {{$seller[$key]}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="info-table">
                                    <td>
                                        @lang('marketplace::app.admin.account.profile.labels.' . 'email')
                                    </td>
                                    <td class="border-left text-center">
                                        {{$seller->admin['email']}}
                                    </td>
                                </tr>
                                @foreach(['additional_email','phone','additional_phone','landline'] as $key)
                                    <tr class="info-table">
                                        <td>
                                            @lang('marketplace::app.admin.account.profile.labels.' . $key)
                                        </td>
                                        <td class="border-left text-center">
                                            {{$seller[$key]}}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="info-table">
                                    <td>
                                        @if($seller->is_personal)
                                            @lang('marketplace::app.admin.account.profile.labels.id_card')
                                        @else
                                            @lang('marketplace::app.admin.account.profile.labels.license')
                                        @endif
                                    </td>
                                    <td class="border-left text-center" style="display: flex; justify-content: center">
                                        @if($seller['document_url'])
                                            <a href="{{$seller['document_url']}}" target="_blank">
                                                <button class="primary-button">View Document</button>
                                            </a>
                                        @else
                                            Document not available
                                        @endif
                                    </td>
                                </tr>

                                <tr class="info-table">
                                    <td>
                                        @lang('marketplace::app.admin.account.profile.labels.id_card_back')
                                    </td>
                                    <td class="border-left text-center" style="display: flex; justify-content: center">
                                        @if($seller['document_back_url'])
                                            <a href="{{$seller['document_back_url']}}" target="_blank">
                                                <button class="primary-button">View Document</button>
                                            </a>
                                        @else
                                            Document not available
                                        @endif
                                    </td>
                                </tr>

                                <tr class="info-table">
                                    <td>
                                        @lang('marketplace::app.admin.account.profile.labels.expiry_date')
                                    </td>
                                    <td class="border-left text-center">
                                        @if(!isset($seller['expiry_date']))
                                        @elseif($seller->is_expired)
                                        @else
                                        @endif
                                        <form style="display: flex; justify-content: center; align-items: center" action="{{route('admin.sales.sellers.expiry', $seller->id)}}" method="post">
                                            @csrf
                                            <input name="expiry_date" type="date" value="{{$seller->expiry_date}}" style="{{$seller->isExpired? "color: red" : ""}}"/>
                                            <Button class="primary-button" style="margin-left: 50px" type="submit">
                                                Update
                                            </Button>
                                        </form>
                                    </td>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            Orders
                        </p>
                        <x-admin::datagrid :src="route('marketplace.admin.orders.index', ['seller_id' => $seller->id])"
                                           :isMultiRow="true">
                            <template #header="{ columns, records, sortPage, selectAllRecords, applied, isLoading}">
                                <template v-if="! isLoading">
                                    <div
                                        class="row grid grid-cols-4 grid-rows-1 items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800">
                                        <div
                                            class="flex gap-[10px] items-center select-none"
                                            v-for="(columnGroup, index) in [['increment_id', 'seller_orders.status'], ['subtotal', 'method'], ['customer_name', 'orders.created_at']]"
                                        >
                                            <p class="text-gray-600 dark:text-gray-300">
                            <span class="[&>*]:after:content-['_/_']">
                                <template v-for="column in columnGroup">
                                    <span
                                        class="after:content-['/'] last:after:content-['']"
                                        :class="{
                                            'text-gray-800 dark:text-white font-medium': applied.sort.column == column,
                                            'cursor-pointer hover:text-gray-800 dark:hover:text-white': columns.find(columnTemp => columnTemp.index === column)?.sortable,
                                        }"
                                        @click="
                                            columns.find(columnTemp => columnTemp.index === column)?.sortable ? sortPage(columns.find(columnTemp => columnTemp.index === column)): {}
                                        "
                                    >
                                        @{{ columns.find(columnTemp => columnTemp.index === column)?.label }}
                                    </span>
                                </template>
                            </span>

                                                <i
                                                    class="ltr:ml-[5px] rtl:mr-[5px] text-[16px] text-gray-800 dark:text-white align-text-bottom"
                                                    :class="[applied.sort.order === 'asc' ? 'icon-down-stat': 'icon-up-stat']"
                                                    v-if="columnGroup.includes(applied.sort.column)"
                                                ></i>
                                            </p>
                                        </div>
                                    </div>
                                </template>

                                {{-- Datagrid Head Shimmer --}}
                                <template v-else>
                                    <x-admin::shimmer.datagrid.table.head
                                        :isMultiRow="true"></x-admin::shimmer.datagrid.table.head>
                                </template>
                            </template>

                            <template #body="{ columns, records, setCurrentSelectionMode, applied, isLoading }">
                                <template v-if="! isLoading">
                                    <div
                                        class="row grid grid-cols-4 px-[16px] py-[10px] border-b-[1px] dark:border-gray-800 transition-all hover:bg-gray-50 dark:hover:bg-gray-950"
                                        v-for="record in records"
                                    >
                                        {{-- Order Id, Created, Status Section --}}
                                        <div class="">
                                            <div class="flex gap-[10px]">
                                                <div class="flex flex-col gap-[6px]">
                                                    <p class="text-[16px] text-gray-800 dark:text-white font-semibold">
                                                        @{{
                                                        "@lang('admin::app.sales.orders.index.datagrid.id')
                                                        ".replace(':id',
                                                        record.increment_id) }}</p>
                                                    <p v-html="record['seller_orders.status']"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="flex flex-col gap-[6px]">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    @{{ $admin.formatPrice(record.subtotal) }}
                                                </p>
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    @{{record.method }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="flex flex-col gap-[6px]">
                                                <p class="text-gray-600 dark:text-gray-300"
                                                   v-text="record.customer_name"></p>
                                                   <p class="text-gray-600 dark:text-gray-300"
                                                       v-text="record.created_at"></p>
                                            </div>
                                        </div>


                                        <div class="flex justify-end items-center">
                                            <a :href=`{{ route('admin.sales.orders.view', '') }}/${record.order_id}`>
                                                <span
                                                    class="icon-sort-left text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"></span>
                                            </a>
                                        </div>
                                    </div>
                                </template>

                                {{-- Datagrid Body Shimmer --}}
                                <template v-else>
                                    <x-admin::shimmer.datagrid.table.body
                                        :isMultiRow="true"></x-admin::shimmer.datagrid.table.body>
                                </template>
                            </template>
                        </x-admin::datagrid>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            المنتجات
                        </p>
                        <x-admin::datagrid
                            src="{{ route('admin.catalog.products.index', ['seller_id' => $seller->id]) }}"
                            :isMultiRow="true">
                            {{-- Datagrid Header --}}
                            @php
                                $hasPermission = bouncer()->hasPermission('catalog.products.mass-update') || bouncer()->hasPermission('catalog.products.mass-delete');
                            @endphp

                            <template #header="{ columns, records, sortPage, selectAllRecords, applied, isLoading}">
                                <template v-if="! isLoading">
                                    <div
                                        class="row grid grid-cols-[2fr_1fr_1fr] grid-rows-1 items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800  ">
                                        <div
                                            class="flex gap-[10px] items-center select-none"
                                            v-for="(columnGroup, index) in [['name', 'status'], ['price']]"
                                        >
                                            <p class="text-gray-600 dark:text-gray-300">
                            <span class="[&>*]:after:content-['_/_']">
                                <template v-for="column in columnGroup">
                                    <span
                                        class="after:content-['/'] last:after:content-['']"
                                        :class="{
                                            'text-gray-800 dark:text-white font-medium': applied.sort.column == column,
                                            'cursor-pointer hover:text-gray-800 dark:hover:text-white': columns.find(columnTemp => columnTemp.index === column)?.sortable,
                                        }"
                                        @click="
                                            columns.find(columnTemp => columnTemp.index === column)?.sortable ? sortPage(columns.find(columnTemp => columnTemp.index === column)): {}
                                        "
                                    >
                                        @{{ columns.find(columnTemp => columnTemp.index === column)?.label }}
                                    </span>
                                </template>
                            </span>

                                                <i
                                                    class="ltr:ml-[5px] rtl:mr-[5px] text-[16px] text-gray-800 dark:text-white align-text-bottom"
                                                    :class="[applied.sort.order === 'asc' ? 'icon-down-stat': 'icon-up-stat']"
                                                    v-if="columnGroup.includes(applied.sort.column)"
                                                ></i>
                                            </p>
                                        </div>
                                    </div>
                                </template>

                                {{-- Datagrid Head Shimmer --}}
                                <template v-else>
                                    <x-admin::shimmer.datagrid.table.head
                                        :isMultiRow="true"></x-admin::shimmer.datagrid.table.head>
                                </template>
                            </template>

                            {{-- Datagrid Body --}}
                            <template #body="{ columns, records, setCurrentSelectionMode, applied, isLoading }">
                                <template v-if="! isLoading">
                                    <div
                                        class="row grid grid-cols-[2fr_1fr_1fr] grid-rows-1 px-[16px] py-[10px] border-b-[1px] dark:border-gray-800   transition-all hover:bg-gray-50 dark:hover:bg-gray-950  "
                                        v-for="record in records"
                                    >
                                        {{-- Name, SKU, Attribute Family Columns --}}
                                        <div class="flex gap-[10px]">
                                            
                                            <div class="flex gap-[6px]">
                                                <p
                                                    class="text-[16px] text-gray-800 dark:text-white font-semibold flex items-center"
                                                    v-text="record.name"
                                                >
                                                </p>

                                                <p :class="[record.status ? 'label-active': 'label-info'] + ' flex items-center'">
                                                    @{{ record.status ?
                                                    "@lang('admin::app.catalog.products.index.datagrid.active')" :
                                                    "@lang('admin::app.catalog.products.index.datagrid.disable')" }}
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Image, Price, Id, Stock Columns --}}
                                        <div class="flex gap-[6px]">
                                            <div class="flex flex-col gap-[6px]">
                                                <p
                                                    class="text-[16px] text-gray-800 dark:text-white font-semibold"
                                                    v-text="$admin.formatPrice(record.price)"
                                                >
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex gap-x-[16px] justify-end">
                                            <a :href=`{{ route('shop.product_or_category.index', '') }}/${record.url_key}`
                                               target="_blank">
                                                <span
                                                    class="icon-view text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] rounded-[6px] cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 "></span>
                                            </a>
                                            <a :href=`{{ route('admin.catalog.products.edit', '') }}/${record.product_id}`>
                                                <span
                                                    class="icon-sort-left text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] rounded-[6px] cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 "></span>
                                            </a>
                                        </div>
                                    </div>
                                </template>

                                {{-- Datagrid Body Shimmer --}}
                                <template v-else>
                                    <x-admin::shimmer.datagrid.table.body
                                        :isMultiRow="true"></x-admin::shimmer.datagrid.table.body>
                                </template>
                            </template>
                        </x-admin::datagrid>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin::layouts>
