<x-admin::layouts>
    <x-slot:title>
        {{ __('New Shipping Trip') }}
    </x-slot:title>

    <x-admin::form :action="route('admin.delivery.trips.store')" method="POST" enctype="multipart/form-data">
        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                {{ __('New Shipping Trip') }}
            </p>

            <div class="flex gap-x-[10px] items-center">
                <button type="submit">
                    <div class="primary-button">
                        {{ __('Save') }}
                    </div>
                </button>
            </div>
        </div>

        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class=" flex flex-col gap-[8px] flex-1 max-xl:flex-auto">

                <div class="p-[16px] bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <x-admin::form.control-group.control type="hidden" value="1" name="direction" />
                    <x-admin::form.control-group class="mb-[10px]">
                        <x-admin::form.control-group.label class="required">
                            {{ __('Driver') }}
                        </x-admin::form.control-group.label>

                        {{-- Select Seller Orders --}}
                        <x-admin::form.control-group.control type="select" name="driver_id"
                            placeholder="{{ __('Driver') }}" label="{{ __('Driver') }}">
                            @foreach ($drivers as $id => $driver)
                                <option value="{{ $id }}">
                                    {{ $driver }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="driver_id">
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                </div>
            </div>
        </div>
    </x-admin::form>

</x-admin::layouts>
