<x-admin::layouts>
    <x-slot:title>
        {{ __('Warehouses') }}
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            {{ __('Warehouses') }}
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.delivery.warehouses.create') }}">
                <div class="primary-button">
                    {{ __('Create Warehouse') }}
                </div>
            </a>
        </div>
    </div>

    <x-admin::datagrid src="{{ route('admin.delivery.warehouses.index') }}"></x-admin::datagrid>

</x-admin::layouts>
