<div
        class="w-full max-w-[870px] mx-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px] h-fit" style="height: fit-content"
>

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
        <x-shop::form :action="route('shop.customers.register.store')">

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.first-name')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                        type="text"
                        name="first_name"
                        class="!p-[20px_25px] rounded-lg"
                        :value="old('last_name')"
                        rules="required"
                        :label="trans('shop::app.customers.signup-form.first-name')"
                        :placeholder="trans('shop::app.customers.signup-form.first-name')"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                        control-name="first_name"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.last-name')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                        type="text"
                        name="last_name"
                        class="!p-[20px_25px] rounded-lg"
                        :value="old('last_name')"
                        rules="required"
                        :label="trans('shop::app.customers.signup-form.last-name')"
                        :placeholder="trans('shop::app.customers.signup-form.last-name')"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                        control-name="last_name"
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


            <x-shop::form.control-group class="mb-6">
                <x-shop::form.control-group.label class="required">
                    @lang('shop::app.customers.signup-form.password')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                        type="password"
                        name="password"
                        class="!p-[20px_25px] rounded-lg"
                        :value="old('password')"
                        rules="required|min:6|strong_password"
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


            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label>
                    @lang('shop::app.customers.signup-form.confirm-pass')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                        type="password"
                        name="password_confirmation"
                        class="!p-[20px_25px] rounded-lg"
                        value=""
                        rules="confirmed:@password"
                        :label="trans('shop::app.customers.signup-form.password')"
                        :placeholder="trans('shop::app.customers.signup-form.confirm-pass')"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                        control-name="password_confirmation"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            @if (core()->getConfigData('customer.captcha.credentials.status'))
                <div class="flex mb-[20px]">
                    {!! Captcha::render() !!}
                </div>
            @endif

            @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                <div class="flex gap-[6px] items-center select-none">
                    <input
                            type="checkbox"
                            name="is_subscribed"
                            id="is-subscribed"
                            class="hidden peer"
                            onchange="switchVisibility()"
                    />

                    <label
                            class="icon-uncheck text-[24px] text-navyBlue peer-checked:icon-check-box peer-checked:text-navyBlue cursor-pointer"
                            for="is-subscribed"
                    ></label>

                    <label
                            class="pl-0 text-[16] text-[#6E6E6E] max-sm:text-[12px] select-none cursor-pointer"
                            for="is-subscribed"
                    >
                        @lang('shop::app.customers.signup-form.subscribe-to-newsletter')
                    </label>
                </div>
            @endif


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
           href="{{ route('shop.customer.session.index') }}"
        >
            @lang('shop::app.customers.signup-form.sign-in-button')
        </a>
    </p>
</div>
