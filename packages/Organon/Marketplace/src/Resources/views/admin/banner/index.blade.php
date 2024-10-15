<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.banners.index.title')
    </x-slot:title>

    <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('marketplace::app.admin.banners.index.title')
        </p>

        <div class="flex gap-x-[10px] items-center">
            <a href="{{ route('admin.banners.create.main') }}">
                <div class="primary-button">
                    @lang('marketplace::app.admin.banners.main.title')
                </div>
            </a>  
            <a href="{{ route('admin.banners.create.area') }}">
                <div class="primary-button">
                    @lang('marketplace::app.admin.banners.area.title')
                </div>
            </a>  
            <a href="{{ route('admin.banners.create.category') }}">
                <div class="primary-button">
                    @lang('marketplace::app.admin.banners.category.title')
                </div>
            </a>    
        </div>
    </div>

    <x-admin::datagrid :src="route('admin.banners.index')" :isMultiRow="true">
    </x-admin::datagrid>
</x-admin::layouts>
