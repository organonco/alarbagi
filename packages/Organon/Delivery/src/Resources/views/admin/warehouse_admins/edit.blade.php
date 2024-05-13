<x-admin::layouts>
    <x-slot:title>
        {{ __('Edit Warehouse Admin') }}
    </x-slot:title>

    <x-admin::form :action="route('admin.delivery.warehouse_admins.update', $warehouseAdmin->id)" enctype="multipart/form-data">
        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                {{ __('Edit Warehouse Admin') }}
            </p>

            <div class="flex gap-x-[10px] items-center">
                <a href="{{ route('admin.delivery.warehouse_admins.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white ">
                    {{ __('Back') }}
                </a>

                <button type="submit" class="primary-button">
                    {{ __('Save Warehouse Admin') }}
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
                            placeholder="{{ __('Name') }}" label="{{ __('Name') }}"
                            value="{{ $warehouseAdmin->name }}">

                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="name">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Email') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="email" maxlength="1000"
                            placeholder="{{ __('Email') }}" label="{{ __('Email') }}"
                            value="{{ $warehouseAdmin->email }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="email">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Phone') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="phone" maxlength="1000"
                            placeholder="{{ __('Phone') }}" label="{{ __('Phone') }}"
                            value="{{ $warehouseAdmin->phone }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="phone">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>


                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Warehouses') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="multiselect" name="warehouses[]"
                            placeholder="{{ __('Warehouses') }}" label="{{ __('Warehouses') }}">
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" @selected(in_array($warehouse->id, $warehouseAdmin->selected_warehouses_ids))>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="warehouses">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>

    </x-admin::form>

    <x-admin::form :action="route('admin.delivery.warehouse_admins.update_password', $warehouseAdmin->id)" enctype="multipart/form-data">
        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="pb-[16px]">
                        Update Password
                    </div>
                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('New Password') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="password" maxlength="1000"
                            placeholder="{{ __('New Password') }}" label="{{ __('New Password') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="password">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('New Password Confirmation') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="text" name="password_confirmation"
                            maxlength="1000" placeholder="{{ __('New Password Again') }}"
                            label="{{ __('New Password Confirmation') }}">
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="password_confirmation">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <button type="submit" class="primary-button mt-[16px]">
                        {{ __('Save Warehouse Admin') }}
                    </button>
                </div>

            </div>
        </div>
    </x-admin::form>

    @push('scripts')
    @endpush

</x-admin::layouts>
