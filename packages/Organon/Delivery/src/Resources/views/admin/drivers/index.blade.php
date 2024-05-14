<x-admin::layouts>
    <x-slot:title>
        {{ __('Drivers') }}
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            {{ __('Drivers') }}
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.delivery.drivers.create') }}">
                <div class="primary-button">
                    {{ __('Create Driver') }}
                </div>
            </a>
        </div>
    </div>

    <x-admin::datagrid src="{{ route('admin.delivery.drivers.index') }}"></x-admin::datagrid>

</x-admin::layouts>
