<x-admin::layouts>
    <x-slot:title>
        Sellers
    </x-slot:title>

    @push('styles')
        <style>
            .info-table td {
                padding-right: 80px;
            }
        </style>
    @endpush

    {{-- Header --}}
    <div class="grid">
        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <div class="flex gap-[10px] items-center">
                <p class="text-[20px] text-gray-800 dark:text-white font-bold leading-[24px]">
                    {{$seller->name}}
                </p>

                <div>
                    <span class="label-{{trans('marketplace::app.seller.statuses.'. $seller->status->name . '.class')}} text-[14px] mx-[5px]">
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
                <div class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                     @click="$emitter.emit('open-confirm-modal', {message: '@lang('marketplace::app.admin.sellers.view.activate-msg')', agree: () => {this.$refs['activateForm'].submit()}})">
                    <form method="POST" ref="activateForm"
                          action="{{ route('admin.sales.sellers.activate', $seller->id) }}"> @csrf </form>
                    <span class="icon-tick text-[24px]"></span>
                    <a href="javascript:void(0);"> @lang('marketplace::app.admin.sellers.view.activate')</a>
                </div>
            @endif
            @if($seller->isDeactivatable())
                <div class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
                     @click="$emitter.emit('open-confirm-modal', {message: '@lang('marketplace::app.admin.sellers.view.deactivate-msg')',agree: () => {this.$refs['deactivateForm'].submit()}})">
                    <form method="POST" ref="deactivateForm"
                          action="{{ route('admin.sales.sellers.deactivate', $seller->id) }}">@csrf</form>
                    <span class="icon-cancel text-[24px]"></span>
                    <a href="javascript:void(0);">@lang('marketplace::app.admin.sellers.view.deactivate')</a>
                </div>
            @endif

            @if($seller->hasDraftInvoice())
                <div class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]">
                    <span class="icon-calendar text-[24px]"></span>
                    <a href="{{route('admin.sales.sellers.invoice.view', ['invoice_id' => $seller->getDraftInvoiceId()])}}">@lang('marketplace::app.admin.sellers.view.edit-invoice')</a>
                </div>
            @else
                <div class="inline-flex gap-x-[8px] items-center justify-between w-full max-w-max px-[4px] py-[6px] text-gray-600 dark:text-gray-300 font-semibold text-center cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"
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
                            <table>
                                @foreach(['name','description','address','slug','payment_method','deliver_by'] as $key)
                                    <tr class="info-table">
                                        <td>
                                            @lang('marketplace::app.admin.account.profile.labels.' . $key):

                                        </td>
                                        <td>
                                            {{$seller[$key] ?? '-'}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="info-table">
                                    <td>
                                        @lang('marketplace::app.admin.account.profile.labels.' . 'email'):

                                    </td>
                                    <td>
                                        {{$seller->admin['email']}}
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
                                    <div class="row grid grid-cols-4 grid-rows-1 items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800">
                                        <div
                                                class="flex gap-[10px] items-center select-none"
                                                v-for="(columnGroup, index) in [['increment_id', 'orders.created_at', 'seller_orders.status'], ['number_of_products', 'subtotal', 'method'], ['customer_name', 'customer_email', 'customer_address']]"
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
                                                    <p class="text-gray-600 dark:text-gray-300"
                                                       v-text="record.created_at"></p>
                                                    <p v-html="record['seller_orders.status']"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="flex flex-col gap-[6px]">
                                                <p class="text-gray-600 dark:text-gray-300"
                                                   v-text="record.number_of_products"></p>
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    @{{ $admin.formatPrice(record.subtotal) }}
                                                </p>
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    @lang('admin::app.sales.orders.index.datagrid.pay-by', ['method' => ''])
                                                    @{{
                                                    record.method }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="flex flex-col gap-[6px]">
                                                <p class="text-gray-600 dark:text-gray-300"
                                                   v-text="record.customer_name"></p>
                                                <p class="text-gray-600 dark:text-gray-300"
                                                   v-text="record.customer_email"></p>
                                                <p class="text-gray-600 dark:text-gray-300"
                                                   v-text="record.customer_address"></p>
                                            </div>
                                        </div>


                                        <div class="flex justify-end items-center">
                                            <a :href=`{{ route('admin.sales.orders.view', '') }}/${record.order_id}`>
                                                <span class="icon-sort-right text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800 hover:rounded-[6px]"></span>
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
                            Products
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
                                    <div class="row grid grid-cols-[2fr_1fr_1fr] grid-rows-1 items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800  ">
                                        <div
                                                class="flex gap-[10px] items-center select-none"
                                                v-for="(columnGroup, index) in [['name', 'sku', 'attribute_family'], ['base_image', 'price', 'quantity', 'product_id'], ['status', 'category_name', 'type']]"
                                        >

                                            @if ($hasPermission)
                                                <label
                                                        class="flex gap-[4px] items-center w-max cursor-pointer select-none"
                                                        for="mass_action_select_all_records"
                                                        v-if="! index"
                                                >
                                                    <input
                                                            type="checkbox"
                                                            name="mass_action_select_all_records"
                                                            id="mass_action_select_all_records"
                                                            class="hidden peer"
                                                            :checked="['all', 'partial'].includes(applied.massActions.meta.mode)"
                                                            @change="selectAllRecords"
                                                    >

                                                    <span
                                                            class="icon-uncheckbox cursor-pointer rounded-[6px] text-[24px]"
                                                            :class="[
                                        applied.massActions.meta.mode === 'all' ? 'peer-checked:icon-checked peer-checked:text-blue-600' : (
                                            applied.massActions.meta.mode === 'partial' ? 'peer-checked:icon-checkbox-partial peer-checked:text-blue-600' : ''
                                        ),
                                    ]"
                                                    >
                                </span>
                                                </label>
                                            @endif

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
                                            @if ($hasPermission)
                                                <input
                                                        type="checkbox"
                                                        :name="`mass_action_select_record_${record.product_id}`"
                                                        :id="`mass_action_select_record_${record.product_id}`"
                                                        :value="record.product_id"
                                                        class="hidden peer"
                                                        v-model="applied.massActions.indices"
                                                        @change="setCurrentSelectionMode"
                                                >

                                                <label
                                                        class="icon-uncheckbox rounded-[6px] text-[24px] cursor-pointer peer-checked:icon-checked peer-checked:text-blue-600"
                                                        :for="`mass_action_select_record_${record.product_id}`"
                                                ></label>
                                            @endif

                                            <div class="flex flex-col gap-[6px]">
                                                <p
                                                        class="text-[16px] text-gray-800 dark:text-white font-semibold"
                                                        v-text="(record.seller_name? record.seller_name: '') + (record.seller_name && record.name ? ' | ' : '') +  (record.name? record.name : '')"
                                                >
                                                </p>

                                                <p
                                                        class="text-gray-600 dark:text-gray-300"
                                                >
                                                    @{{ "@lang('admin::app.catalog.products.index.datagrid.sku-value')
                                                    ".replace(':sku', record.sku) }}
                                                </p>

                                                <p
                                                        class="text-gray-600 dark:text-gray-300"
                                                >
                                                    @{{
                                                    "@lang('admin::app.catalog.products.index.datagrid.attribute-family-value')
                                                    ".replace(':attribute_family', record.attribute_family) }}
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Image, Price, Id, Stock Columns --}}
                                        <div class="flex gap-[6px]">
                                            <div class="relative">
                                                <template v-if="record.base_image">
                                                    <img
                                                            class="min-h-[65px] min-w-[65px] max-h-[65px] max-w-[65px] rounded-[4px]"
                                                            :src=`{{ Storage::url('') }}${record.base_image}`
                                                    />

                                                    <span
                                                            class="absolute bottom-[1px] ltr:left-[1px] rtl:right-[1px] text-[12px] font-bold text-white bg-darkPink rounded-full px-[6px]"
                                                            v-text="record.images_count"
                                                    >
                                </span>
                                                </template>

                                                <template v-else>
                                                    <div class="w-full h-[60px] max-w-[60px] max-h-[60px] relative border border-dashed border-gray-300 dark:border-gray-800 rounded-[4px] dark:invert dark:mix-blend-exclusion">
                                                        <img
                                                                src="{{ bagisto_asset('images/product-placeholders/front.svg')}}"
                                                        >

                                                        <p class="w-full absolute bottom-[5px] text-[6px] text-gray-400 text-center font-semibold">
                                                            @lang('admin::app.catalog.products.index.datagrid.product-image')
                                                        </p>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="flex flex-col gap-[6px]">
                                                <p
                                                        class="text-[16px] text-gray-800 dark:text-white font-semibold"
                                                        v-text="$admin.formatPrice(record.price)"
                                                >
                                                </p>

                                                <!-- Parent Product Quantity -->
                                                <div v-if="['configurable', 'bundle', 'grouped'].includes(record.type)">
                                                    <p class="text-gray-600 dark:text-gray-300">
                                                        <span class="text-red-600" v-text="'N/A'"></span>
                                                    </p>
                                                </div>

                                                <div v-else>
                                                    <p
                                                            class="text-gray-600 dark:text-gray-300"
                                                            v-if="record.quantity > 0"
                                                    >
                                    <span class="text-green-600">
                                        @{{ "@lang('admin::app.catalog.products.index.datagrid.qty-value')".replace(':qty', record.quantity) }}
                                    </span>
                                                    </p>

                                                    <p
                                                            class="text-gray-600 dark:text-gray-300"
                                                            v-else
                                                    >
                                    <span class="text-red-600">
                                        @lang('admin::app.catalog.products.index.datagrid.out-of-stock')
                                    </span>
                                                    </p>
                                                </div>

                                                <p class="text-gray-600 dark:text-gray-300">
                                                    @{{ "@lang('admin::app.catalog.products.index.datagrid.id-value')
                                                    ".replace(':id', record.product_id) }}
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Status, Category, Type Columns --}}
                                        <div class="flex gap-x-[16px] justify-between items-center">
                                            <div class="flex flex-col gap-[6px]">
                                                <p :class="[record.status ? 'label-active': 'label-info']">
                                                    @{{ record.status ?
                                                    "@lang('admin::app.catalog.products.index.datagrid.active')" :
                                                    "@lang('admin::app.catalog.products.index.datagrid.disable')" }}
                                                </p>

                                                <p
                                                        class="text-gray-600 dark:text-gray-300"
                                                        v-text="record.category_name ?? 'N/A'"
                                                >
                                                </p>

                                                <p
                                                        class="text-gray-600 dark:text-gray-300"
                                                        v-text="record.type"
                                                >
                                                </p>
                                            </div>

                                            <a :href=`{{ route('shop.product_or_category.index', '') }}/${record.url_key}`
                                               target="_blank">
                                                <span class="icon-view text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] rounded-[6px] cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 "></span>
                                            </a>
                                            <a :href=`{{ route('admin.catalog.products.edit', '') }}/${record.product_id}`>
                                                <span class="icon-sort-right text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] rounded-[6px] cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 "></span>
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
