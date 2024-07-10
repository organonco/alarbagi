<div
    class="w-full max-w-[870px] mx-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px] h-fit"
>
    <h1 class="sn-color-primary sn-heading-1">
        
        @lang('marketplace::app.register.title.seller')
    </h1>

    <p class="sn-color-primary sn-heading-3">
        @lang('marketplace::app.register.desc.seller')
    </p>

    <div class="mt-[60px] rounded max-sm:mt-[30px]">
        <x-shop::form :action="route('shop.marketplace.register')" enctype="multipart/form-data">
            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('marketplace::app.register.labels.shop_name')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    name="name"
                    class="!p-[20px_25px] rounded-lg"
                    :value="old('name')"
                    rules="required"
                    :label="trans('marketplace::app.register.labels.shop_name')"
                    :placeholder="trans('marketplace::app.register.labels.shop_name')"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                    control-name="name"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.email')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="email"
                    name="email"
                    class="!p-[20px_25px] rounded-lg"
                    :value="old('email')"
                    rules="required|email"
                    :label="trans('shop::app.customers.signup-form.email')"
                    placeholder="email@example.com"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                    control-name="email"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.phone')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    name="phone"
                    class="!p-[20px_25px] rounded-lg"
                    :value="old('phone')"
                    rules="required|phone"
                    :label="trans('shop::app.customers.signup-form.phone')"
                    placeholder="23456789"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                    control-name="phone"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.landline')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    name="landline"
                    class="!p-[20px_25px] rounded-lg"
                    :value="old('landline')"
                    rules="required|phone"
                    :label="trans('shop::app.customers.signup-form.landline')"
                    placeholder="23456789"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                    control-name="landline"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.address')
                </x-shop::form.control-group.label>
                <x-shop::form.control-group.control
                    type="textarea"
                    name="address"
                    class="!p-[20px_25px] rounded-lg"
                    rules="required"
                    :value="old('address')"
                    :label="trans('shop::app.customers.signup-form.address')"
                    placeholder="9530 Moses Drive, Abbotthaven, LA 57274"
                >
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error
                    control-name="address"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.password')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="password"
                    name="password"
                    class="!p-[20px_25px] rounded-lg"
                    :value="old('password')"
                    rules="required|min:8"
                    ref="password"
                    :label="trans('shop::app.customers.signup-form.password')"
                    :placeholder="trans('shop::app.customers.signup-form.password')"
                    autocomplete="new-password"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                    control-name="password"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            
            <div class="flex gap-[36px] flex-wrap items-center mt-[30px]">
                <button
                    class="block w-full max-w-[1260px] sn-button-primary"
                    type="submit"
                >
                    @lang('shop::app.customers.signup-form.button-title')
                </button>
            </div>


        </x-shop::form>
    </div>

    <p class="my-[20px] text-[#6E6E6E] font-medium">
        @lang('shop::app.customers.signup-form.account-exists')

        <a class="text-navyBlue"
           href="{{ route('admin.session.create') }}"
        >
            @lang('shop::app.customers.signup-form.sign-in-button')
        </a>
    </p>
</div>

