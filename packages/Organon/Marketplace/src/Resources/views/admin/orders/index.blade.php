<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.sales.orders.index.title')
    </x-slot:title>

    <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('admin::app.sales.orders.index.title')
        </p>

        <div class="flex gap-x-[10px] items-center">
            <!-- Export Modal -->
            <x-admin::datagrid.export src="{{ route('marketplace.admin.orders.index') }}"></x-admin::datagrid.export>
        </div>
    </div>

    <x-admin::datagrid :src="route('marketplace.admin.orders.index')" :isMultiRow="true">
        {{-- Datagrid Header --}}
        <template #header="{ columns, records, sortPage, selectAllRecords, applied, isLoading}">
            <template v-if="! isLoading">
                <div class="row grid grid-cols-4 grid-rows-1 items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800">
                    <div
                            class="flex gap-[10px] items-center select-none"
                            v-for="(columnGroup, index) in [['increment_id', 'orders.created_at', 'seller_orders.status'], ['number_of_products', 'subtotal'], ['customer_name', 'shipping_title', 'area']]"
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
                <x-admin::shimmer.datagrid.table.head :isMultiRow="true"></x-admin::shimmer.datagrid.table.head>
            </template>
        </template>

        <template #body="{ columns, records, setCurrentSelectionMode, applied, isLoading }">
            <template v-if="! isLoading">
                <a :href=`{{ route('marketplace.admin.orders.view', '') }}/${record.id}`
                        class="row grid grid-cols-4 px-[16px] py-[10px] border-b-[1px] dark:border-gray-800 transition-all hover:bg-gray-50 dark:hover:bg-gray-950"
                        v-for="record in records"
                >
                    {{-- Order Id, Created, Status Section --}}
                    <div class="">
                        <div class="flex gap-[10px]">
                            <div class="flex flex-col gap-[6px]">
                                <p class="text-[16px] text-gray-800 dark:text-white font-semibold">@{{
                                    "@lang('admin::app.sales.orders.index.datagrid.id')".replace(':id',
                                    record.increment_id) }}</p>
                                <p class="text-gray-600 dark:text-gray-300" v-text="record.created_at"></p>
                                <p v-html="record['seller_orders.status']"></p>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="flex flex-col gap-[6px]">
                            <p class="text-gray-600 dark:text-gray-300" v-text="record.number_of_products"></p>
                            <p class="text-gray-600 dark:text-gray-300">
                                @{{ $admin.formatPrice(record.subtotal) }}
                            </p>
                        </div>
                    </div>

                    <div class="">
                        <div class="flex flex-col gap-[6px]">
                            <p class="text-gray-600 dark:text-gray-300" v-text="record.customer_name"></p>
                            <p class="text-gray-600 dark:text-gray-300" v-text="record.shipping_title"></p>
                            <p class="text-gray-600 dark:text-gray-300" v-text="record.area"></p>
                        </div>
                    </div>
                </a>
            </template>

            {{-- Datagrid Body Shimmer --}}
            <template v-else>
                <x-admin::shimmer.datagrid.table.body :isMultiRow="true"></x-admin::shimmer.datagrid.table.body>
            </template>
        </template>
    </x-admin::datagrid>
</x-admin::layouts>
