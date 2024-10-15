<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.banners.edit.title')
    </x-slot:title>

    <x-admin::form :action="route('admin.banners.update.area', $banner->id)" enctype="multipart/form-data">

        <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('marketplace::app.admin.banners.edit.title')
            </p>
            <button type="submit" class="primary-button">
                @lang('marketplace::app.general.save')
            </button>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap content-center justify-center">
            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <x-admin::form.control-group class="mb-[10px]">
                    <x-admin::form.control-group.label class="required">
                        @lang('delivery::app.shipping-company.attributes.area_id')
                    </x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="select" name="area_id" value="{{$banner->area_id}}">
                        @foreach ($areas as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </x-admin::form.control-group.control>
                    <x-admin::form.control-group.error control-name="area_id">
                    </x-admin::form.control-group.error>
                </x-admin::form.control-group>
                
                <x-admin::form.control-group class="mb-[10px]">
                    <x-admin::form.control-group.label>
                    @lang('marketplace::app.admin.banners.create.attributes.mobile')
                    </x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="switch" name="is_mobile" value="1" :checked="$banner->is_mobile && true">
                    </x-admin::form.control-group.control>
                    <x-admin::form.control-group.error control-name="is_mobile">
                    </x-admin::form.control-group.error>
                </x-admin::form.control-group>

                <x-admin::form.control-group class="mb-[10px]">
                    <x-admin::form.control-group.label>
                    @lang('marketplace::app.admin.banners.create.attributes.banner')
                    </x-admin::form.control-group.label>
                    <x-admin::media.images type="image" name="banner" :uploaded-images="$banner->banner_url ? [['id' => 'image', 'url' => $banner->banner_url]] : []" accepted-types="image/*">
                    </x-admin::media.images >
                    <x-admin::form.control-group.error control-name="banner">
                    </x-admin::form.control-group.error>
                </x-admin::form.control-group>
            </div>
        </div>
    </x-admin::form>
</x-admin::layouts>
