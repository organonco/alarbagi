<x-admin::layouts>
    <x-slot:title>
        Invoices
    </x-slot:title>

    <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            Invoices
        </p>

        <div class="flex gap-x-[10px] items-center">
            <x-admin::datagrid.export src="{{ route('admin.sales.sellers.invoice.index') }}"></x-admin::datagrid.export>
        </div>
    </div>

    <x-admin::datagrid :src="route('admin.sales.sellers.invoice.index')">
    </x-admin::datagrid>
</x-admin::layouts>
