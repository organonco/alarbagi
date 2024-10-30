<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.offers.index.title')
    </x-slot:title>

    <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('marketplace::app.admin.offers.index.title')
        </p>

        <div class="flex gap-x-[10px] items-center">
            <x-admin::datagrid.export src="{{ route('admin.offers.index') }}"></x-admin::datagrid.export>
            @if (auth()->guard('admin')->user()->isSeller())
                <a href="{{ route('admin.offers.create') }}">
                    <div class="primary-button">
                        @lang('marketplace::app.admin.offers.create.title')
                    </div>
                </a>
            @endif
        </div>
    </div>

    <x-admin::datagrid :src="route('admin.offers.index')" :isMultiRow="true">
    </x-admin::datagrid>
</x-admin::layouts>
