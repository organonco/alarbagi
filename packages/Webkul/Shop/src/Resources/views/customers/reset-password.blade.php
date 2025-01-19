{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.forgot-password.title')" />

    <meta name="keywords" content="@lang('shop::app.customers.forgot-password.title')" />
@endPush

<x-shop::layouts :has-header="true" :has-feature="false" :has-footer="false">
    {{-- Page Title --}}
    <x-slot:title>
        @lang('shop::app.customers.reset-password.title')
    </x-slot>

    <div class="container mt-20 max-1180:px-[20px]">

        {{-- Form Container --}}
        <div
            class="w-full max-w-[870px] m-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px]">
            <h1 class="text-[40px] font-dmserif max-sm:text-[25px] sn-color-light-main">
                @lang('shop::app.customers.reset-password.title')
            </h1>

            <p class="mt-[15px] text-[#6E6E6E] text-[20px] max-sm:text-[16px]">
                @lang('shop::app.customers.reset-password.text')
            </p>

            <div class="mt-[60px] rounded max-sm:mt-[30px]">
                <x-shop::form :action="route('shop.customers.forgot_password.reset', $token)">

                    <x-shop::form.control-group class="mb-4">
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.reset-form.code')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control type="text" name="code"
                            class="!p-[20px_25px] rounded-lg" value="" rules="required" :label="trans('shop::app.customers.reset-form.code')"
                            :placeholder="trans('shop::app.customers.reset-form.code')">
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="code">
                        </x-shop::form.control-group.error>
                    </x-shop::form.control-group>

                    <x-shop::form.control-group class="mb-4">
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.reset-form.password')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control type="password" name="password"
                            class="!p-[20px_25px] rounded-lg" value="" rules="required|min:8|strong_password" :label="trans('shop::app.customers.reset-form.password')"
                            :placeholder="trans('shop::app.customers.reset-form.password')">
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="password">
                        </x-shop::form.control-group.error>
                    </x-shop::form.control-group>

                    <x-shop::form.control-group class="mb-4">
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.reset-form.password_confirmation')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control type="password" name="password_confirmation"
                            class="!p-[20px_25px] rounded-lg" value="" rules="required|confirmed:@password"  :label="trans('shop::app.customers.reset-form.password_confirmation')"
                            :placeholder="trans('shop::app.customers.reset-form.password_confirmation')">
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="password_confirmation">
                        </x-shop::form.control-group.error>
                    </x-shop::form.control-group>

                    <div class="flex gap-[36px] flex-wrap mt-[30px] items-center">
                        <button class="sn-button-primary" type="submit">
                            @lang('shop::app.customers.forgot-password.submit')
                        </button>
                    </div>

                </x-shop::form>
            </div>
        </div>
    </div>
</x-shop::layouts>
