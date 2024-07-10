<x-admin::layouts>
    <x-slot:title>
        @lang('delivery::app.shipping-company.titles.index')
    </x-slot:title>

    <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('delivery::app.shipping-company.titles.index')
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.delivery.shipping-company.create') }}">
                <div class="primary-button">
                    @lang('delivery::app.shipping-company.titles.create')
                </div>
            </a>
        </div>
    </div>

    <x-admin::datagrid :src="route('admin.delivery.shipping-company.index')" :isMultiRow="true">
    </x-admin::datagrid>
</x-admin::layouts>
