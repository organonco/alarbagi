<x-admin::layouts>
    <x-slot:title>
        {{ __('Warehouse Admins') }}
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            {{ __('Warehouse Admins') }}
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.delivery.warehouse_admins.create') }}">
                <div class="primary-button">
                    {{ __('Create Warehouse Admin') }}
                </div>
            </a>
        </div>
    </div>

    <x-admin::datagrid src="{{ route('admin.delivery.warehouse_admins.index') }}"></x-admin::datagrid>

</x-admin::layouts>
