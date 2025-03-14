<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.account.profile.page-title')
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('marketplace::app.admin.account.profile.page-title')
        </p>
    </div>

    {{--    Image/Cover/Bio/Name/Address       --}}

    <div class="justify-between gap-x-[4px] gap-y-[8px] items-center flex-wrap mt-[20px]">
        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            @lang('marketplace::app.admin.account.profile.actions.update')
                        </p>

                        <x-admin::form :action="route('admin.account.profile.update')" enctype="multipart/form-data">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label
                                        class="required">@lang('marketplace::app.admin.account.profile.labels.name')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="text"
                                        name="name"
                                        value="{{$seller->name}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.name')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.name')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="name"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required"
                                >@lang('marketplace::app.admin.account.profile.labels.address')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="textarea"
                                        name="address"
                                        rows="5"
                                        maxlength="1000"
                                        value="{{$seller->address}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.address')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.address')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="address"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required"
                                >@lang('marketplace::app.admin.account.profile.labels.phone')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="text"
                                        name="phone"
                                        value="{{$seller->phone}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.phone')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.phone')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="phone"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required"
                                >@lang('marketplace::app.admin.account.profile.labels.landline')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="text"
                                        name="landline"
                                        value="{{$seller->landline}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.landline')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.landline')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="landline"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

							<x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required"
                                >@lang('marketplace::app.admin.account.profile.labels.opening_days')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="text"
                                        name="opening_days"
                                        value="{{$seller->opening_days}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.opening_days')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.opening_days')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="opening_days"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

							<x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required"
                                >@lang('marketplace::app.admin.account.profile.labels.opening_time')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="text"
                                        name="opening_time"
                                        value="{{$seller->opening_time}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.opening_time')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.opening_time')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="opening_time"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

							<x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required"
                                >@lang('marketplace::app.admin.account.profile.labels.owner_name')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="text"
                                        name="owner_name"
                                        value="{{$seller->owner_name}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.owner_name')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.owner_name')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="owner_name"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>


                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>@lang('marketplace::app.admin.account.profile.labels.logo')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="file"
                                        name="logo"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="logo"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

                            <div class="flex gap-[36px] flex-wrap items-center mt-[30px]">
                                <button
                                        class="primary-button py-[8px] w-full block px-[43px] mx-auto m-0 ml-[0px] rounded-[18px] text-[16px] text-center"
                                        type="submit"
                                >
                                    @lang('marketplace::app.admin.account.profile.actions.update')
                                </button>
                            </div>
                        </x-admin::form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>
