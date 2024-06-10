<div
    class="w-full max-w-[870px] mx-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px] h-fit"
>
    <h1 class="text-[40px] font-dmserif max-sm:text-[25px] sn-color-light-main">
        @lang('marketplace::app.register.title.seller')
    </h1>

    <p class="mt-[15px] sn-color-secondary text-[20px] max-sm:text-[16px]">
        @lang('marketplace::app.register.desc.seller')
    </p>

    <div class="mt-[60px] rounded max-sm:mt-[30px]">
        <x-shop::form :action="route('shop.marketplace.register')" enctype="multipart/form-data">
            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    @lang('marketplace::app.register.labels.shop_name')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="textarea"
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
                <x-shop::form.control-group.label>
                    @lang('shop::app.customers.signup-form.additional-email')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="email"
                    name="additional_email"
                    class="!p-[20px_25px] rounded-lg"
                    :value="old('additional_email')"
                    rules="email"
                    :label="trans('shop::app.customers.signup-form.additional-email')"
                    placeholder="email@example.com"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                    control-name="additional_email"
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
                <x-shop::form.control-group.label>
                    @lang('shop::app.customers.signup-form.additional-phone')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    name="additional_phone"
                    class="!p-[20px_25px] rounded-lg"
                    :value="old('additional_phone')"
                    rules="phone"
                    :label="trans('shop::app.customers.signup-form.additional-phone')"
                    placeholder="23456789"
                >
                </x-shop::form.control-group.control>

                <x-shop::form.control-group.error
                    control-name="additional_phone"
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


            <x-shop::form.control-group class="mb-6">
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

            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label>
                    @lang('shop::app.customers.signup-form.individual-account')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="switch"
                    name="is_personal"
                    class="!p-[20px_25px] rounded-lg"
                    onClick="switchType()"
                >
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error
                    control-name="is_personal"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>


            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required">
                    <div id="document_label" style="display: inline">
                        @lang('shop::app.customers.signup-form.id')
                    </div>
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="file"
                    name="document"
                    rules=""
                    class="!p-[20px_25px] rounded-lg"
                >
                </x-shop::form.control-group.control>
                <x-shop::form.control-group.error
                    control-name="document"
                >
                </x-shop::form.control-group.error>
            </x-shop::form.control-group>

            <div id="document_back">
                <x-shop::form.control-group class="mb-4">
                    <x-shop::form.control-group.label class="required">
                        <div style="display: inline">
                            @lang('shop::app.customers.signup-form.id-back')
                        </div>
                    </x-shop::form.control-group.label>
                    <x-shop::form.control-group.control
                        type="file"
                        name="document_back"
                        rules=""
                        class="!p-[20px_25px] rounded-lg"
                    >
                    </x-shop::form.control-group.control>
                    <x-shop::form.control-group.error
                        control-name="document_back"
                    >
                    </x-shop::form.control-group.error>
                </x-shop::form.control-group>
            </div>

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
           href="{{ route('admin.session.create') }}"
        >
            @lang('shop::app.customers.signup-form.sign-in-button')
        </a>
    </p>
</div>



@push('scripts')

    <script>


        function switchType() {
            const switchElement = document.getElementById('is_personal');
            const labelElement = document.getElementById('document_label');
            const documentBackDiv = document.getElementById('document_back');

            if (switchElement.checked) {
                labelElement.innerHTML = "@lang('shop::app.customers.signup-form.id')"
                documentBackDiv.style.display = 'block'
            } else {
                labelElement.innerHTML = "@lang('shop::app.customers.signup-form.license')"
                documentBackDiv.style.display = 'none'
            }
        }

    </script>
@endpush
