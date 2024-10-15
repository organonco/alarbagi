<x-admin::layouts>
    <x-slot:title>
        @lang('delivery::app.area.titles.edit')
    </x-slot:title>

    <x-admin::form :action="route('admin.delivery.area.update', $area->id)" enctype="multipart/form-data">

        <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('delivery::app.area.titles.edit') -
                @lang('delivery::app.area.titles.no-company-assigned')
            </p>
            <button type="submit" class="primary-button">
                @lang('delivery::app.area.titles.save')
            </button>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            {{-- Left Section --}}
            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.area.attributes.name')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="text" name="name" value="{{ $area->name }}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="name">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.area.attributes.sort')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="number" name="sort" value="{{ $area->sort }}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="sort">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('delivery::app.area.attributes.info')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="textarea" name="info" value="{{ $area->info }}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="info">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.area.attributes.is_active')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="switch" name="is_active" value="1"
                            :checked="(bool) $area->is_active">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="is_active">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('marketplace::app.admin.seller_categories.create.attributes.image')
                        </x-admin::form.control-group.label>
                        <x-admin::media.images type="image" name="image" :uploaded-images="$area->image_url ? [['id' => 'image', 'url' => $area->image_url]] : []" accepted-types="image/*">
                        </x-admin::media.images>
                        <x-admin::form.control-group.error control-name="image">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>


    </x-admin::form>
</x-admin::layouts>
