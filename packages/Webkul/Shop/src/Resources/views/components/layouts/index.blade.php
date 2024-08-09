@props([
    'hasHeader'  => true,
    'hasFeature' => true,
    'hasFooter'  => true,
])

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction }}">
    <head>
        <title>{{ $title ?? '' }}</title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url()->to('/') }}">
        <meta name="currency-code" content="{{ core()->getCurrentCurrencyCode() }}">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">

        @stack('meta')

        @laravelPWA

        @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" as="style">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-style.css') . '?' . time()}}"/>

        <link rel="preload" href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" as="style">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap">

        <link rel="stylesheet" href="{{asset('assets/css/style.css') . '?' . time()}}}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">


        @stack('styles')

        <style>
            {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
        </style>

        {!! view_render_event('bagisto.shop.layout.head') !!}
    </head>

    <body>
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        <div id="app">
            {{-- Flash Message Blade Component --}}
            <x-shop::flash-group />

            {{-- Confirm Modal Blade Component --}}
            <x-shop::modal.confirm />

            {{-- Page Header Blade Component --}}
            @if ($hasHeader)
                <x-shop::layouts.header />
            @endif

            {!! view_render_event('bagisto.shop.layout.content.before') !!}

            {{-- Page Content Blade Component --}}
			<div class="max-lg:mb-24">
            	{{ $slot }}
			</div>

            {!! view_render_event('bagisto.shop.layout.content.after') !!}

            {{-- Page Features Blade Component --}}
            {{-- @if ($hasFeature)
                <x-shop::layouts.features />
            @endif --}}

            {{-- Page Footer Blade Component --}}
            {{-- @if ($hasFooter)
                <x-shop::layouts.footer />
            @endif --}}

			<div class="max-lg:grid hidden fixed bottom-0 w-full grid-cols-5 sn-background-secondary py-4 ">
				<a class="flex flex-col items-center px-1 border-l sn-border-color-primary" href="{{route("shop.customers.account.wishlist.index")}}">
					<img class="w-8 h-8" src="{{ asset('assets/images/icons/bar/heart.png') }}"/>
					<div class="sn-color-primary text-center mt-2  {{Route::currentRouteName() == "shop.customers.account.wishlist.index" ? "sn-heading-3 underline" : ""}}">
						المفضلة
					</div>
				</a>
				<a class="flex flex-col items-center px-1 border-l sn-border-color-primary" href="{{route("offer.index")}}">
					<img class="w-8 h-8" src="{{ asset('assets/images/icons/bar/offers.png') }}"/>
					<div class="sn-color-primary text-center mt-2 {{Route::currentRouteName() == "offer.index" ? "sn-heading-3 underline" : ""}}">
						العروض
					</div>
				</a>

				<a class="flex flex-col items-center px-1 border-l sn-border-color-primary" href="{{route("shop.home.index")}}">
					<img class="w-8 h-8" src="{{ asset('assets/images/icons/bar/main.png') }}"/>
					<div class="sn-color-primary text-center mt-2 {{Route::currentRouteName() == "shop.home.index" ? "sn-heading-3 underline" : ""}}">
						الرئيسية
					</div>
				</a>

				<a class="flex flex-col items-center px-1 border-l sn-border-color-primary" href="{{route("shop.checkout.cart.index")}}">
					<img class="w-8 h-8" src="{{ asset('assets/images/icons/bar/cart.png') }}"/>
					<div class="sn-color-primary text-center mt-2 {{Route::currentRouteName() == "shop.checkout.cart.index" ? "sn-heading-3 underline" : ""}}">
						العربة
					</div>
				</a>

				<a class="flex flex-col items-center px-1 " href="{{route("shop.customers.account.profile.index")}}">
					<img class="w-8 h-8" src="{{ asset('assets/images/icons/bar/user.png') }}"/>
					<div class="sn-color-primary text-center mt-2 {{Route::currentRouteName() == "shop.customers.account.profile.index" ? "sn-heading-3 underline" : ""}}">
						الحساب
					</div>
				</a>
			</div>
        </div>

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        @stack('scripts')

        <script type="text/javascript">
            {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
        </script>
    </body>
</html>
