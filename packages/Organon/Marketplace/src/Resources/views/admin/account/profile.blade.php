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
                            Update Profile Info
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
                                <x-admin::form.control-group.label
                                        class="required">@lang('marketplace::app.admin.account.profile.labels.slug')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="text"
                                        name="slug"
                                        value="{{$seller->slug}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.slug')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.slug')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="slug"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>


                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label
                                >@lang('marketplace::app.admin.account.profile.labels.description')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                        type="textarea"
                                        name="description"
                                        rows="5"
                                        maxlength="1000"
                                        value="{{$seller->description}}"
                                        placeholder="{{trans('marketplace::app.admin.account.profile.labels.description')}}"
                                        label="{{trans('marketplace::app.admin.account.profile.labels.description')}}"
                                >
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="description"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label
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
