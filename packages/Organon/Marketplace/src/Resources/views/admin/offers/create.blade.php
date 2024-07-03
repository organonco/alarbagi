<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.offers.create.title')
    </x-slot:title>

    <x-admin::form :action="route('admin.offers.store')" enctype="multipart/form-data">

        <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('marketplace::app.admin.offers.create.title')
            </p>
            <button type="submit" class="primary-button">
                @lang('marketplace::app.general.save')
            </button>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('marketplace::app.admin.offers.create.attributes.title')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="text" name="title">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="title">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('marketplace::app.admin.offers.create.attributes.post')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="textarea" name="post">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="post">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('marketplace::app.admin.offers.create.attributes.image')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="image" name="image">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="image">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('marketplace::app.admin.offers.create.attributes.status')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="switch" name="status" value="1">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="status">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                </div>
            </div>
        </div>


    </x-admin::form>
</x-admin::layouts>
