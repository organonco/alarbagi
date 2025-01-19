{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.login-form.page-title')" />

    <meta name="keywords" content="@lang('shop::app.customers.login-form.page-title')" />
@endPush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.login-form.page-title')
    </x-slot>

    <div class="container mt-20 max-1180:px-[20px]">
        {{-- Company Logo --}}

        {{-- Form Container --}}
        <div
            class="w-full max-w-[870px] m-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px]">
            <img src="{{ asset('assets/images/logo.png') }}" class="mx-auto mb-12 lg:w-[40%] w-[70%]" />
            <h1 class="sn-color-primary sn-heading-1">
                @lang('shop::app.customers.login-form.page-title')
            </h1>

            <p class="sn-color-primary sn-heading-3">
                @lang('shop::app.customers.login-form.form-login-text.first')
                <a href="{{ route('admin.session.create') }}" class="sn-color-secondary sn-heading-3">
                    @lang('shop::app.customers.login-form.form-login-text.last')
                </a>
            </p>

            {!! view_render_event('bagisto.shop.customers.login.before') !!}

            <div class="mt-[60px] rounded max-sm:mt-[30px]">
                <x-shop::form :action="route('shop.customer.session.create')">

                    <x-shop::form.control-group class="mb-4">
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.login-form.phone')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control type="text" name="phone"
                            class="!p-[20px_25px] rounded-lg" value="" rules="required" :label="trans('shop::app.customers.login-form.phone')"
                            :placeholder="trans('shop::app.customers.login-form.phone')">
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="phone">
                        </x-shop::form.control-group.error>
                    </x-shop::form.control-group>

                    <x-shop::form.control-group class="mb-4">
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.login-form.password')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control type="password" name="password"
                            class="!p-[20px_25px] rounded-lg" valu e="" id="password" rules="required|min:6"
                            :label="trans('shop::app.customers.login-form.password')" :placeholder="trans('shop::app.customers.login-form.password')">
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="password">
                        </x-shop::form.control-group.error>
                    </x-shop::form.control-group>

                    <div class="flex justify-between">
                        <div class="select-none items-center flex gap-[6px]">
                            <input type="checkbox" id="show-password" class="hidden peer"
                                onchange="switchVisibility()" />

                            <label
                                class="icon-uncheck text-[24px] text-navyBlue peer-checked:icon-check-box peer-checked:text-navyBlue cursor-pointer"
                                for="show-password"></label>

                            <label class="text-[16] text-[#6E6E6E] max-sm:text-[12px] pl-0 select-none cursor-pointer"
                                for="show-password">
                                @lang('shop::app.customers.login-form.show-password')
                            </label>
                        </div>

                        <div class="block">
                            <a href="{{ route('shop.customers.forgot_password.create') }}"
                                class="text-[16px] cursor-pointer text-black max-sm:text-[12px]">
                                <span>
                                    @lang('shop::app.customers.login-form.forgot-pass')
                                </span>
                            </a>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}

                    @if (core()->getConfigData('customer.captcha.credentials.status'))
                        <div class="flex mt-[20px]">
                            {!! Captcha::render() !!}
                        </div>
                    @endif

                    <div class="flex gap-[36px] flex-wrap mt-[30px] items-center">
                        <button class="block w-full max-w-[1260px] sn-button-primary" type="submit">
                            @lang('shop::app.customers.login-form.button-title')
                        </button>

                        {!! view_render_event('bagisto.shop.customers.login.after') !!}

                    </div>
                </x-shop::form>
            </div>

            <p class="mt-[20px] text-[#6E6E6E] font-medium">
                @lang('shop::app.customers.login-form.new-customer')

                <a class="text-navyBlue" href="{{ route('shop.customers.register.index') }}">
                    @lang('shop::app.customers.login-form.create-your-account')
                </a>
            </p>


        </div>

    </div>

    @push('scripts')
        {!! Captcha::renderJS() !!}

        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");

                passwordField.type = passwordField.type === "password" ?
                    "text" :
                    "password";
            }
        </script>
    @endpush
</x-shop::layouts>
