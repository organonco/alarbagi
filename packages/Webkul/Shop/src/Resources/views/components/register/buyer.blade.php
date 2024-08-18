<div class="w-full max-w-[870px] mx-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px] h-fit"
    style="height: fit-content">

    <img src="{{ asset('assets/images/logo.png') }}" class="mx-auto mb-12 lg:w-[40%] w-[70%]" />


    <h1 class="sn-color-primary sn-heading-1">
        @lang('marketplace::app.register.title.customer')
    </h1>

    <p class="sn-color-primary sn-heading-3">
        @lang('marketplace::app.register.desc.customer.first')
        <a href="{{ route('shop.customers.register.index-seller') }}" class="sn-color-secondary sn-heading-3">
            @lang('marketplace::app.register.desc.customer.last')
        </a>
    </p>

    <div class="mt-[60px] rounded max-sm:mt-[30px]">
        <x-shop::form :action="route('shop.customers.register.store')" id="registerForm">

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.first-name')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="text" name="first_name" class="!p-[20px_25px] rounded-lg"
                    :value="old('first_name')" rules="required" :label="trans('shop::app.customers.signup-form.first-name')" :placeholder="trans('shop::app.customers.signup-form.first-name')">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="first_name">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.last-name')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="text" name="last_name" class="!p-[20px_25px] rounded-lg"
                    :value="old('last_name')" rules="required" :label="trans('shop::app.customers.signup-form.last-name')" :placeholder="trans('shop::app.customers.signup-form.last-name')">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="last_name">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.account.profile.gender')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="select" name="gender" :value="old('gender')" rules="required"
                    aria-label="الجنس" class="rounded-lg " style="padding: 20px 40px" :label="trans('shop::app.customers.account.profile.gender')">
                    <option value="ذكر">@lang('shop::app.customers.account.profile.male')</option>
                    <option value="أنثى">@lang('shop::app.customers.account.profile.female')</option>
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="gender">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.account.profile.dob')
                </x-shop::form.control-group.label>
                <div class="grid grid-cols-4 w-full gap-6 max-lg:gap-1">
                    <x-shop::form.control-group.control type="number" name="birth_d"
                        class="col-span-1 !p-[20px_10px] text-center rounded-lg [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        :value="old('birth_d')" rules="required|between:1,31" :label="trans('shop::app.customers.account.profile.birth_d')"
                        placeholder="{{ trans('shop::app.customers.account.profile.birth_d') }}">
                    </x-shop::form.control-group.control>
                    <x-shop::form.control-group.control type="number" name="birth_m"
                        class="col-span-1 !p-[20px_10px] text-center rounded-lg [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        :value="old('birth_m')" rules="required|between:1,12" :label="trans('shop::app.customers.account.profile.birth_m')"
                        placeholder="{{ trans('shop::app.customers.account.profile.birth_m') }}">
                    </x-shop::form.control-group.control>
                    <x-shop::form.control-group.control type="number" name="birth_y"
                        class="col-span-2 !p-[20px_10px] text-center rounded-lg [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        :value="old('birth_y')" rules="required|min_value:1900" :label="trans('shop::app.customers.account.profile.birth_y')"
                        placeholder="{{ trans('shop::app.customers.account.profile.birth_y') }}">
                    </x-shop::form.control-group.control>
                </div>
                <x-shop::form.control-group.error control-name="birth_d">
                </x-shop::form.control-group.error>
                <x-shop::form.control-group.error control-name="birth_m">
                </x-shop::form.control-group.error>
                <x-shop::form.control-group.error control-name="birth_y">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.account.profile.phone')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="text" name="phone" :value="old('phone')"
                    rules="required|phone" :label="trans('shop::app.customers.account.profile.phone')" :placeholder="trans('shop::app.customers.account.profile.phone')" class="!p-[20px_25px] rounded-lg">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="phone">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.email')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="email" name="email" class="!p-[20px_25px] rounded-lg"
                    :value="old('email')" rules="required|email" :label="trans('shop::app.customers.signup-form.email')" placeholder="email@example.com">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="email">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('marketplace::app.register.labels.area_id')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="select" name="area_id" class="rounded-lg"
                    style="padding: 20px 40px" :value="old('area_id')" rules="" :label="trans('marketplace::app.register.labels.area_id')">
                    @foreach ($areas as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                    <option value="">أخرى</option>
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="name">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.address')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="textarea" name="address_details"
                    class="!p-[20px_25px] rounded-lg" rules="required" :value="old('address_details')" :label="trans('shop::app.customers.signup-form.address')"
                    placeholder="">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="address_details">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-6">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.password')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="password" name="password" class="!p-[20px_25px] rounded-lg"
                    :value="old('password')" rules="required|min:6|strong_password" ref="password" :label="trans('shop::app.customers.signup-form.password')"
                    :placeholder="trans('shop::app.customers.signup-form.password')" autocomplete="new-password">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="password">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.confirm-pass')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control type="password" name="password_confirmation"
                    class="!p-[20px_25px] rounded-lg" value="" rules="confirmed:@password" :label="trans('shop::app.customers.signup-form.password')"
                    :placeholder="trans('shop::app.customers.signup-form.confirm-pass')">
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error control-name="password_confirmation">
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <label class="relative inline-flex items-start cursor-pointer">
                    <v-field type="checkbox" name="terms" class="hidden" v-slot="{ field }" rules="required"
                        value="0" label="قبول شروط العربجي">
                        <input type="checkbox" name="terms" id="terms" class="sr-only peer" v-bind="field" />
                    </v-field>
                    <label
                        class="rounded-full h-[20px] bg-gray-200 cursor-pointer peer-focus:ring-blue-300 after:bg-white after:border-gray-300 peer-checked:bg-[#F67541] peer peer-checked:after:border-white peer-checked:after:ltr:translate-x-full peer-checked:after:rtl:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:ltr:left-[2px] after:rtl:right-[2px] peer-focus:outline-none after:border after:rounded-full after:h-[16px] after:w-[16px] after:transition-all w-14"
                        for="terms">
                    </label>
                    <div class="flex flex-col">
                        <label class="mx-2 sn-color-primary">
                            أنا أوافق على
                            <a class="sn-color-secondary" href="{{ route('shop.cms.page', 'terms-of-use') }}"
                                target="_blank">شروط استخدام </a>
                            <a class="sn-color-secondary" href="{{ route('shop.cms.page', 'privacy-policy') }}"
                                target="_blank">وسياسة خصوصية</a>
                            منصة العربجي
                        </label>
                        <x-shop::form.control-group.error control-name="terms">
                        </x-shop::form.control-group.error>
                    </div>
                </label>
            </x-shop::form.control-group>




            <div class="flex gap-[36px] flex-wrap items-center mt-[30px]">
                <button class="block w-full max-w-[1260px] sn-button-primary" type="submit" id="registerButton">
                    @lang('shop::app.customers.signup-form.button-title')
                </button>
            </div>


        </x-shop::form>
    </div>

    <p class="my-[20px] text-[#6E6E6E] font-medium">
        @lang('shop::app.customers.signup-form.account-exists')

        <a class="text-navyBlue" href="{{ route('shop.customer.session.index') }}">
            @lang('shop::app.customers.signup-form.sign-in-button')
        </a>
    </p>
</div>
