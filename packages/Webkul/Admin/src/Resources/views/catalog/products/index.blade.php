<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.catalog.products.index.title')
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('admin::app.catalog.products.index.title')
        </p>

        <div class="flex gap-x-[10px] items-center">

            <!-- Export Modal -->
            <x-admin::datagrid.export src="{{ route('admin.catalog.products.index') }}"></x-admin::datagrid.export>

            {!! view_render_event('bagisto.admin.catalog.products.create.before') !!}

            @if (bouncer()->hasPermission('catalog.products.create') && auth()->guard('admin')->user()->isSeller())
                <v-create-product-form>
                    <button type="button" class="primary-button">
                        @lang('admin::app.catalog.products.index.create-btn')
                    </button>
                </v-create-product-form>
            @endif

            {!! view_render_event('bagisto.admin.catalog.products.create.after') !!}
        </div>
    </div>

    {!! view_render_event('bagisto.admin.catalog.products.list.before') !!}

    {{-- Datagrid --}}
    <x-admin::datagrid src="{{ route('admin.catalog.products.index') }}" :isMultiRow="true">
        {{-- Datagrid Header --}}
        @php
            $hasPermission =
                bouncer()->hasPermission('catalog.products.mass-update') ||
                bouncer()->hasPermission('catalog.products.mass-delete');
        @endphp

        <template #header="{ columns, records, sortPage, selectAllRecords, applied, isLoading}">
            <template v-if="! isLoading">
                <div
                    class="row grid grid-cols-[2fr_1fr_1fr] grid-rows-1 items-center px-[16px] py-[10px] border-b-[1px] dark:border-gray-800  ">
                    <div class="flex gap-[10px] items-center select-none"
                        v-for="(columnGroup, index) in [['name', 'seller_name'], ['status', 'price', ], ['base_image']]">

                        <p class="text-gray-600 dark:text-gray-300">
                            <span class="[&>*]:after:content-['_/_']">
                                <template v-for="column in columnGroup">
                                    <span class="after:content-['/'] last:after:content-['']"
                                        :class="{
                                            'text-gray-800 dark:text-white font-medium': applied.sort.column == column,
                                            'cursor-pointer hover:text-gray-800 dark:hover:text-white': columns.find(
                                                columnTemp => columnTemp.index === column)?.sortable,
                                        }"
                                        @click="
                                            columns.find(columnTemp => columnTemp.index === column)?.sortable ? sortPage(columns.find(columnTemp => columnTemp.index === column)): {}
                                        ">
                                        @{{ columns.find(columnTemp => columnTemp.index === column)?.label }}
                                    </span>
                                </template>
                            </span>

                            <i class="ltr:ml-[5px] rtl:mr-[5px] text-[16px] text-gray-800 dark:text-white align-text-bottom"
                                :class="[applied.sort.order === 'asc' ? 'icon-down-stat' : 'icon-up-stat']"
                                v-if="columnGroup.includes(applied.sort.column)"></i>
                        </p>
                    </div>
                </div>
            </template>

            {{-- Datagrid Head Shimmer --}}
            <template v-else>
                <x-admin::shimmer.datagrid.table.head :isMultiRow="true"></x-admin::shimmer.datagrid.table.head>
            </template>
        </template>

        {{-- Datagrid Body --}}
        <template #body="{ columns, records, setCurrentSelectionMode, applied, isLoading }">
            <template v-if="! isLoading">
                <div class="row grid grid-cols-[2fr_1fr_1fr] grid-rows-1 px-[16px] py-[10px] border-b-[1px] dark:border-gray-800   transition-all hover:bg-gray-50 dark:hover:bg-gray-950  "
                    v-for="record in records">
                    {{-- Name, SKU, Attribute Family Columns --}}
                    <div class="flex gap-[10px]">
                        <div>
                            <a :href=`{{ route('shop.product_or_category.index', '') }}/${record.url_key}`
                                target="_blank">
                                <span
                                    class="icon-view text-[24px] ltr:ml-[4px] rtl:mr-[4px] p-[6px] rounded-[6px] cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 "></span>
                            </a>
                            <a :href=`{{ route('admin.catalog.products.edit', '') }}/${record.product_id}`>
                                <span
                                    class="icon-sort-right text-[30px] ltr:ml-[4px] rtl:mr-[4px] rounded-[6px] cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-800 "></span>
                            </a>
                        </div>

                        <div class="flex flex-col gap-[6px]">
                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold" v-text="record.name">
                            </p>

                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold"
                                v-text="record.seller_name">
                            </p>

                        </div>
                    </div>

                    {{-- Image, Price, Id, Stock Columns --}}
                    <div class="flex gap-[6px]">



                        <div class="flex flex-col gap-[6px]">
                            <p :class="[record.status ? 'label-active' : 'label-info']">
                                @{{ record.status ? "@lang('admin::app.catalog.products.index.datagrid.active')" :
    "@lang('admin::app.catalog.products.index.datagrid.disable')" }}
                            </p>
                            <p class="text-[16px] text-gray-800 dark:text-white font-semibold" v-text="record.price">
                            </p>
                        </div>
                    </div>

                    {{-- Status, Category, Type Columns --}}
                    <div class="flex gap-x-[16px] justify-between items-center">

                        <div class="flex flex-col gap-[6px]">
                            <div class="relative">
                                <template v-if="record.base_image">
                                    <img class="min-h-[65px] min-w-[65px] max-h-[65px] max-w-[65px] rounded-[4px]"
                                        :src=`{{ Storage::url('') }}${record.base_image}` />

                                    <span
                                        class="absolute bottom-[1px] ltr:left-[1px] rtl:right-[1px] text-[12px] font-bold text-white bg-darkPink rounded-full px-[6px]"
                                        v-text="record.images_count">
                                    </span>
                                </template>

                                <template v-else>
                                    <div
                                        class="w-full h-[60px] max-w-[60px] max-h-[60px] relative border border-dashed border-gray-300 dark:border-gray-800 rounded-[4px] dark:invert dark:mix-blend-exclusion">
                                        <img src="{{ bagisto_asset('images/product-placeholders/front.svg') }}">

                                        <p
                                            class="w-full absolute bottom-[5px] text-[6px] text-gray-400 text-center font-semibold">
                                            @lang('admin::app.catalog.products.index.datagrid.product-image')
                                        </p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Datagrid Body Shimmer --}}
            <template v-else>
                <x-admin::shimmer.datagrid.table.body :isMultiRow="true"></x-admin::shimmer.datagrid.table.body>
            </template>
        </template>
    </x-admin::datagrid>

    {!! view_render_event('bagisto.admin.catalog.products.list.after') !!}

    @pushOnce('scripts')
        <script type="text/x-template" id="v-create-product-form-template">
            <div>
                <!-- Product Create Button -->
                @if (bouncer()->hasPermission('catalog.products.create') && auth()->guard('admin')->user()->isSeller())
                    <button
                            type="button"
                            class="primary-button"
                            @click="$refs.productCreateModal.toggle()"
                    >
                        @lang('admin::app.catalog.products.index.create-btn')
                    </button>
                @endif

                <x-admin::form
                        v-slot="{ meta, errors, handleSubmit }"
                        as="div"
                >
                    <form @submit="handleSubmit($event, create)">
                        <!-- Customer Create Modal -->
                        <x-admin::modal ref="productCreateModal">
                            <x-slot:header>
                                <!-- Modal Header -->
                                <p
                                        class="text-[18px] text-gray-800 dark:text-white font-bold"
                                        v-if="! attributes.length"
                                >
                                    @lang('admin::app.catalog.products.index.create.title')
                                </p>

                                <p
                                        class="text-[18px] text-gray-800 dark:text-white font-bold"
                                        v-else
                                >
                                    @lang('admin::app.catalog.products.index.create.configurable-attributes')
                                </p>
                            </x-slot:header>

                            <x-slot:content>
                                <!-- Modal Content -->
                                <div class="px-[16px] py-[10px] border-b-[1px] dark:border-gray-800  ">
                                    <div v-show="! attributes.length">
                                        {!! view_render_event('bagisto.admin.catalog.products.create_form.general.controls.before') !!}

                                        <x-admin::form.control-group>

                                            <x-admin::form.control-group.control
                                                    type="hidden"
                                                    name="type"
                                                    value="simple"
                                                    rules="required"
                                                    :label="trans('admin::app.catalog.products.index.create.type')"
                                            >
                                                @foreach(config('product_types') as $key => $type)
                                                    <option value="{{ $key }}">
                                                        @lang('admin::app.catalog.products.index.create.' . $key)
                                                    </option>
                                                @endforeach
                                            </x-admin::form.control-group.control>

                                            <x-admin::form.control-group.error
                                                    control-name="type"></x-admin::form.control-group.error>
                                        </x-admin::form.control-group>

                                        <x-admin::form.control-group>

                                            <x-admin::form.control-group.control
                                                    type="hidden"
                                                    name="attribute_family_id"
                                                    rules="required"
                                                    value="1"
                                                    :label="trans('admin::app.catalog.products.index.create.family')"
                                            >
                                                @foreach($families as $family)
                                                    <option value="{{ $family->id }}">
                                                        {{ $family->name }}
                                                    </option>
                                                @endforeach
                                            </x-admin::form.control-group.control>

                                            <x-admin::form.control-group.error
                                                    control-name="attribute_family_id"></x-admin::form.control-group.error>
                                        </x-admin::form.control-group>

                                        <x-admin::form.control-group class="mb-[10px]">
                                            <x-admin::form.control-group.label class="required">
                                                @lang('admin::app.catalog.products.index.create.name')
                                            </x-admin::form.control-group.label>

                                            <x-admin::form.control-group.control
                                                    type="text"
                                                    name="name"
                                                    ::rules="{ required: true }"
                                                    :label="trans('admin::app.catalog.products.index.create.name')"
                                            >
                                            </x-admin::form.control-group.control>

                                            <x-admin::form.control-group.error
                                                    control-name="name"></x-admin::form.control-group.error>
                                        </x-admin::form.control-group>

                                        {!! view_render_event('bagisto.admin.catalog.products.create_form.general.controls.before') !!}
                                    </div>

                                    <div v-show="attributes.length">
                                        {!! view_render_event('bagisto.admin.catalog.products.create_form.attributes.controls.before') !!}

                                        <div
                                                class="mb-[10px]"
                                                v-for="attribute in attributes"
                                        >
                                            <label class="block leading-[24px] text-[12px] text-gray-800 dark:text-white font-medium">
                                                @{{ attribute.name }}
                                            </label>

                                            <div class="flex flex-wrap gap-[4px] min-h-[38px] p-[6px] border dark:border-gray-800 rounded-[6px]">
                                                <p
                                                        class="flex items-center py-[3px] px-[8px] bg-gray-600 rounded-[4px] text-white font-semibold"
                                                        v-for="option in attribute.options"
                                                >
                                                    @{{ option.name }}

                                                    <span
                                                            class="icon-cross text-white text-[18px] ltr:ml-[5px] rtl:mr-[5px] cursor-pointer"
                                                            @click="removeOption(option)"
                                                    ></span>
                                                </p>
                                            </div>
                                        </div>

                                        {!! view_render_event('bagisto.admin.catalog.products.create_form.attributes.controls.before') !!}
                                    </div>
                                </div>
                            </x-slot:content>

                            <x-slot:footer>
                                <!-- Modal Submission -->
                                <div class="flex gap-x-[10px] items-center">
                                    <button
                                            type="button"
                                            class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white "
                                            v-if="attributes.length"
                                            @click="attributes = []"
                                    >
                                        @lang('admin::app.catalog.products.index.create.back-btn')
                                    </button>

                                    <button
                                            type="submit"
                                            class="primary-button"
                                    >
                                        @lang('admin::app.catalog.products.index.create.save-btn')
                                    </button>
                                </div>
                            </x-slot:footer>
                        </x-admin::modal>
                    </form>
                </x-admin::form>
            </div>
        </script>

        <script type="module">
            app.component('v-create-product-form', {
                template: '#v-create-product-form-template',

                data() {
                    return {
                        attributes: [],

                        superAttributes: {}
                    };
                },

                methods: {
                    create(params, {
                        resetForm,
                        resetField,
                        setErrors
                    }) {
                        this.attributes.forEach(attribute => {
                            params.super_attributes ||= {};

                            params.super_attributes[attribute.code] = this.superAttributes[attribute.code];
                        });

                        this.$axios.post("{{ route('admin.catalog.products.store') }}", params)
                            .then((response) => {
                                if (response.data.data.redirect_url) {
                                    window.location.href = response.data.data.redirect_url;
                                } else {
                                    this.attributes = response.data.data.attributes;

                                    this.setSuperAttributes();
                                }
                            })
                            .catch(error => {
                                if (error.response.status == 422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },

                    removeOption(option) {
                        this.attributes.forEach(attribute => {
                            attribute.options = attribute.options.filter(item => item.id != option.id);
                        });

                        this.attributes = this.attributes.filter(attribute => attribute.options.length > 0);

                        this.setSuperAttributes();
                    },

                    setSuperAttributes() {
                        this.superAttributes = {};

                        this.attributes.forEach(attribute => {
                            this.superAttributes[attribute.code] = [];

                            attribute.options.forEach(option => {
                                this.superAttributes[attribute.code].push(option.id);
                            });
                        });
                    }
                }
            })
        </script>
    @endPushOnce

</x-admin::layouts>
