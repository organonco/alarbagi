<x-admin::layouts>
    <x-slot:title>
        @lang('marketplace::app.admin.account.settings.page-title')
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="py-[11px] text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('marketplace::app.admin.account.settings.page-title')
        </p>
    </div>

    <div class="justify-between gap-x-[4px] gap-y-[8px] items-center flex-wrap mt-[20px]">
        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            تغيير كلمة المرور
                        </p>
                        <x-admin::form :action="route('admin.account.settings.update-password')">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label
                                        class="required">@lang('marketplace::app.admin.account.settings.labels.current')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control type="password" name="current">
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="current"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label
                                        class="required">@lang('marketplace::app.admin.account.settings.labels.new')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control type="password" name="new">
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error control-name="new"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label
                                        class="required">@lang('marketplace::app.admin.account.settings.labels.confirmation')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control type="password" name="new_confirmation">
                                </x-admin::form.control-group.control>
                                <x-shop::form.control-group.error
                                        control-name="new_confirmation"></x-shop::form.control-group.error>
                            </x-admin::form.control-group>
                            <div class="flex gap-[36px] flex-wrap items-center mt-[30px]">
                                <button
                                        class="primary-button py-[8px] w-full block px-[43px] mx-auto m-0 ml-[0px] rounded-[18px] text-[16px] text-center"
                                        type="submit"
                                >
                                    @lang('marketplace::app.admin.account.settings.actions.update-password')
                                </button>
                            </div>
                        </x-admin::form>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col gap-[8px] flex-1 max-xl:flex-auto">
                <div class="bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <div class="p-[16px]">
                        <p class="text-[16px] text-gray-800 dark:text-white font-semibold mb-[30px]">
                            حالة الحساب
                        </p>

                        @php
                            $active = $seller->status == \Organon\Marketplace\Enums\SellerStatusEnum::ACTIVE;
                            $buttonDisabled = $seller->status == \Organon\Marketplace\Enums\SellerStatusEnum::DEACTIVATED;
                        @endphp

                        <x-admin::form :action="route('admin.account.settings.update-account-status')"
                                       id="changeStatusForm">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label
                                        class="required">@lang('marketplace::app.admin.account.settings.labels.active-status')</x-admin::form.control-group.label>
                                <x-admin::form.control-group.control  type="switch" name="active"
                                                                     value="active" :checked="$active">
                                </x-admin::form.control-group.control>
                            </x-admin::form.control-group>

                            <button
                                    class="{{$buttonDisabled ? 'secondary-button cursor-not-allowed' : 'primary-button'}} py-[8px] block px-[43px] m-0 ml-[0px] rounded-[18px] text-[16px] text-center"
                                    type="submit"
                                    {{$buttonDisabled ? "disabled" : ""}}
                            >
                                @lang('marketplace::app.admin.account.settings.actions.update-account-status')
                            </button>

                        </x-admin::form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-admin::layouts>
