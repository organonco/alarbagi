{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.signup-form.page-title')" />

    <meta name="keywords" content="@lang('shop::app.customers.signup-form.page-title')" />
@endPush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    {{-- Page Title --}}
    <x-slot:title>
        @lang('marketplace::app.register.title.customer')
    </x-slot>

    <div class="mt-20 max-1180:px-[20px]">

        <div class="flex">

            <x-shop::register.buyer :areas="$areas"></x-shop::register.buyer>

        </div>

    </div>

    @push('scripts')
        <script type="module">
            window.onload = function() {
                document.getElementById('registerForm').onsubmit = function() {
                    document.getElementById('registerButton').disabled = true
                };
            }
        </script>
        {!! Captcha::renderJS() !!}
    @endpush
</x-shop::layouts>
