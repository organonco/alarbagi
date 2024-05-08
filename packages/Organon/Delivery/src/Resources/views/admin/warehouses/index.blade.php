<x-admin::layouts>
    <x-slot:title>
        @lang('delivery::app.admin.titles.warehouses')
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('delivery::app.admin.titles.warehouses')
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.delivery.warehouses.create') }}">
                <div class="primary-button">
                    @lang('delivery::app.admin.buttons.create_warehouse')
                </div>
            </a>
        </div>
    </div>

    <x-admin::datagrid src="{{ route('admin.delivery.warehouses.index') }}"></x-admin::datagrid>

</x-admin::layouts>
