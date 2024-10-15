<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.banners.main.title')
    </x-slot:title>

    <x-admin::form :action="route('admin.banners.store.main')" enctype="multipart/form-data">

        <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('marketplace::app.admin.banners.main.title')
            </p>
            <button type="submit" class="primary-button">
                @lang('marketplace::app.general.save')
            </button>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap ">
            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <x-admin::form.control-group class="mb-[10px]">
                    <x-admin::form.control-group.label>
                    @lang('marketplace::app.admin.banners.create.attributes.mobile')
                    </x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="switch" name="is_mobile" value="1">
                    </x-admin::form.control-group.control>
                    <x-admin::form.control-group.error control-name="is_mobile">
                    </x-admin::form.control-group.error>
                </x-admin::form.control-group>

                <x-admin::form.control-group class="mb-[10px]">
                    <x-admin::form.control-group.label>
                    @lang('marketplace::app.admin.banners.create.attributes.banner')
                    </x-admin::form.control-group.label>
                    <x-admin::media.images  type="image" name="banner"  accepted-types="image/*">
                    </x-admin::media.images >
                    <x-admin::form.control-group.error control-name="banner">
                    </x-admin::form.control-group.error>
                </x-admin::form.control-group>
            </div>
        </div>


    </x-admin::form>
</x-admin::layouts>
