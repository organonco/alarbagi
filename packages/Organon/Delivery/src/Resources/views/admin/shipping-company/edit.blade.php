<x-admin::layouts>
    <x-slot:title>
        @lang('delivery::app.shipping-company.titles.edit')
    </x-slot:title>

    <x-admin::form :action="route('admin.delivery.shipping-company.update', $shippingCompany->id)" enctype="multipart/form-data">

        <div class="flex  gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('delivery::app.shipping-company.titles.edit')
            </p>
            <button type="submit" class="primary-button">
                @lang('delivery::app.shipping-company.titles.save')
            </button>
        </div>


        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            {{-- Left Section --}}
            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.shipping-company.attributes.name')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="text" name="name" value="{{$shippingCompany->name}}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="name">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.shipping-company.attributes.username')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="text" name="username" value="{{$shippingCompany->username}}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="username">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('delivery::app.shipping-company.attributes.password')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="password" name="password">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="password">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.shipping-company.attributes.area_id')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="select" name="area_id" value="{{$shippingCompany->area_id}}">
                            @foreach ($areas as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="area_id">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('delivery::app.shipping-company.attributes.info')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="textarea" name="info" value="{{$shippingCompany->info}}">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="info">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.shipping-company.attributes.is_active')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="switch" name="is_active" value="1" :checked="(bool) $shippingCompany->is_active">
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="is_active">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>


    </x-admin::form>
</x-admin::layouts>
