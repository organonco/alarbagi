<x-admin::layouts>

    <!-- Title of the page -->
    <x-slot:title>
        @lang('marketplace::app.admin.orders.index.page-title')
    </x-slot:title>

    <div class="flex gap-[16px] justify-between max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('marketplace::app.admin.orders.index.page-title')
        </p>

        <div class="flex gap-x-[10px] items-center">

        </div>
    </div>

</x-admin::layouts>