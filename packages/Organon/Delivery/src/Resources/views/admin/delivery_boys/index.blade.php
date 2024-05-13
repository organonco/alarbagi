<x-admin::layouts>
    <x-slot:title>
        {{ __('Delivery People') }}
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            {{ __('Delivery People') }}
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.delivery.delivery_boys.create') }}">
                <div class="primary-button">
                    {{ __('Create Delivery Person') }}
                </div>
            </a>
        </div>
    </div>

    <x-admin::datagrid src="{{ route('admin.delivery.delivery_boys.index') }}"></x-admin::datagrid>

</x-admin::layouts>
