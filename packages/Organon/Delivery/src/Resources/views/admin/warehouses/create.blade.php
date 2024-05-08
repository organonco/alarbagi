<x-admin::layouts>
    <x-slot:title>
        @lang('delivery::app.admin.titles.create_warehouse')
    </x-slot:title>

    <x-admin::form :action="route('admin.delivery.warehouses.store')" enctype="multipart/form-data">

        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                @lang('delivery::app.admin.titles.create_warehouse')
            </p>

            <div class="flex gap-x-[10px] items-center">
                <a href="{{ route('admin.delivery.warehouses.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white ">
                    @lang('delivery::app.admin.buttons.cancel')
                </a>

                <button type="submit" class="primary-button">
                    @lang('delivery::app.admin.buttons.create_warehouse')
                </button>
            </div>
        </div>

        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">

                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.admin.inputs.name')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="name" maxlength="1000"
                            placeholder="{{ trans('delivery::app.admin.inputs.name') }}"
                            label="{{ trans('delivery::app.admin.inputs.name') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="name">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.admin.inputs.address')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="textarea" name="address" rows="5"
                            maxlength="1000" placeholder="{{ trans('delivery::app.admin.inputs.address') }}"
                            label="{{ trans('delivery::app.admin.inputs.address') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="address">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            @lang('delivery::app.admin.inputs.emirate')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="select" name="emirate"
                            placeholder="{{ trans('delivery::app.admin.inputs.emirate') }}"
                            label="{{ trans('delivery::app.admin.inputs.emirate') }}">
                            @foreach ($emirates as $emirate)
                                <option value="{{ $emirate }}">
                                    {{ $emirate }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="emirate">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label>
                            @lang('delivery::app.admin.inputs.additional_info')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="textarea" name="additional_info" rows="5"
                            maxlength="1000" placeholder="{{ trans('delivery::app.admin.inputs.additional_info') }}"
                            label="{{ trans('delivery::app.admin.inputs.additional_info') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="additional_info">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                </div>
            </div>
        </div>
    </x-admin::form>


</x-admin::layouts>
