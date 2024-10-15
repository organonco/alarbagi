<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.seller_categories.edit.title')
    </x-slot:title>

    <x-admin::form :action="route('admin.seller_categories.update', $model->id)" enctype="multipart/form-data">

        <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('marketplace::app.admin.seller_categories.edit.title')
            </p>
            <button type="submit" class="primary-button">
                @lang('marketplace::app.general.save')
            </button>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('marketplace::app.admin.seller_categories.create.attributes.name')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="text" name="name" value="{{$model->name}}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="name">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

					<x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('marketplace::app.admin.seller_categories.create.attributes.sort')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="number" name="sort" value="{{$model->sort}}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="sort">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('marketplace::app.admin.seller_categories.create.attributes.parent')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="select" name="parent_id" value="{{$model->parent_id ? $model->parent_id : '0'}}">
                            <option value="0">فئة رئيسية</option>
                            @foreach($categories as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="parent_id">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('marketplace::app.admin.seller_categories.create.attributes.image')
                        </x-admin::form.control-group.label>
                        <x-admin::media.images  type="image" name="image"  :uploaded-images="$model->image_url ? [['id' => 'image', 'url' => $model->image_url]] : []" accepted-types="image/*">
                        </x-admin::media.images >
                        <x-admin::form.control-group.error control-name="image">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>


    </x-admin::form>
</x-admin::layouts>
