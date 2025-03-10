<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.seller_categories.index.title')
    </x-slot:title>

    <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('marketplace::app.admin.seller_categories.index.title')
        </p>

        <div class="flex gap-x-[10px] items-center">
            <x-admin::datagrid.export src="{{ route('admin.seller_categories.index') }}"></x-admin::datagrid.export>
            <a href="{{ route('admin.seller_categories.create') }}">
                <div class="primary-button">
                    @lang('marketplace::app.admin.seller_categories.create.title')
                </div>
            </a>    
        </div>
    </div>

    <x-admin::datagrid :src="route('admin.seller_categories.index')" :isMultiRow="true">
    </x-admin::datagrid>
</x-admin::layouts>
