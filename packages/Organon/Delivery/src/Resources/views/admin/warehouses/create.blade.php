<x-admin::layouts>
    <x-slot:title>
        {{ __('Create Warehouse') }}
    </x-slot:title>

    <x-admin::form :action="route('admin.delivery.warehouses.store')" enctype="multipart/form-data">

        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                {{ __('Create Warehouse') }}
            </p>

            <div class="flex gap-x-[10px] items-center">
                <a href="{{ route('admin.delivery.warehouses.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white ">
                    {{ __('Back') }}
                </a>

                <button type="submit" class="primary-button">
                    {{ __('Create Warehouse') }}
                </button>
            </div>
        </div>

        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">

                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Name') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="name" maxlength="1000"
                            placeholder="{{ __('Name') }}" label="{{ __('Name') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="name">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Address') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="textarea" name="address" rows="5"
                            maxlength="1000" placeholder="{{ __('Address') }}" label="{{ __('Address') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="address">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Emirate') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="select" name="emirate"
                            placeholder="{{ __('Emirate') }}" label="{{ __('Emirate') }}">
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
                            {{ __('Additional Info') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="textarea" name="additional_info" rows="5"
                            maxlength="1000" placeholder="{{ __('Additional Info') }}"
                            label="{{ __('Additional Info') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="additional_info">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Warehouse Admin') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="select" name="warehouse_admin_id"
                            placeholder="{{ __('Warehouse Admin') }}" label="{{ __('Warehouse Admin') }}">
                            @foreach ($warehouse_admins as $admin)
                                <option value="{{ $admin->id }}">
                                    {{ $admin->name }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="warehouse_admin_id">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                </div>
            </div>
        </div>
    </x-admin::form>


</x-admin::layouts>
