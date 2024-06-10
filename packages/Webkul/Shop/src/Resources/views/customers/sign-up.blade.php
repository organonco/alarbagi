{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.signup-form.page-title')"/>

    <meta name="keywords" content="@lang('shop::app.customers.signup-form.page-title')"/>
@endPush

<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('marketplace::app.register.title.customer')
        </x-slot>

        <div class="mt-20 max-1180:px-[20px]">

            <div class="flex">

                <x-shop::register.buyer></x-shop::register.buyer>

            </div>

        </div>

    @push('scripts')
        {!! Captcha::renderJS() !!}

        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");
                let passwordField2 = document.getElementById("password_confirmation");

                passwordField.type = passwordField.type === "password"
                    ? "text"
                    : "password";


                passwordField2.type = passwordField2.type === "password"
                    ? "text"
                    : "password";
            }
        </script>
    @endpush
</x-shop::layouts>
