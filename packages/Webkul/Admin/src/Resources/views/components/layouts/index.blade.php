<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction }}"
    class="{{ request()->cookie('dark_mode') ?? 0 ? 'dark' : '' }}">

<head>
    <title>{{ $title ?? '' }}</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url()->to('/') }}">
    <meta name="currency-code" content="{{ core()->getBaseCurrencyCode() }}">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">

    @stack('meta')

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') . '?' . time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-style.css') . '?' . time() }}" />

    <style>
        {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
    </style>

    {!! view_render_event('bagisto.shop.layout.head') !!}
</head>

<body class="h-full dark:bg-gray-950">
    {!! view_render_event('bagisto.shop.layout.body.before') !!}

    <div id="app" class="h-full">
        {{-- Flash Message Blade Component --}}
        <x-admin::flash-group />

        {{-- Confirm Modal Blade Component --}}
        <x-admin::modal.confirm />

        {!! view_render_event('bagisto.shop.layout.content.before') !!}

        {{-- Page Header Blade Component --}}
        <x-admin::layouts.header />

        <div class="flex gap-[16px] group/container {{ request()->cookie('sidebar_collapsed') ?? 0 ? 'sidebar-collapsed' : '' }}"
            ref="appLayout">
            {{-- Page Sidebar Blade Component --}}
            <x-admin::layouts.sidebar />

            <div
                class="flex-1 max-w-full px-[16px] pt-[11px] pb-[22px] bg-white dark:bg-gray-950 max-lg:!px-[16px] transition-all duration-300 ">
                @php
                    $admin = auth()->guard('admin')->user();
                @endphp

                @if ($admin->isSeller())
                    @if ($admin->seller->status == \Organon\Marketplace\Enums\SellerStatusEnum::DEACTIVATED)
                        <div style="background-color: darkorange; text-align: center; margin-bottom: 20px; padding: 5px">
                            @lang('marketplace::app.settings.messages.account-deactivated-msg')
                        </div>
                    @elseif($admin->seller->status == \Organon\Marketplace\Enums\SellerStatusEnum::PAUSED)
                        <div style="background-color: dodgerblue; text-align: center; margin-bottom: 20px; padding: 5px">
                            @lang('marketplace::app.settings.messages.account-paused-msg')
                        </div>
                    @elseif($admin->seller->status == \Organon\Marketplace\Enums\SellerStatusEnum::PENDING)
                        <div style="background-color: darkorange; text-align: center; margin-bottom: 20px; padding: 5px">
                            @lang('marketplace::app.settings.messages.account-pending-msg')
                        </div>
                    @endif
                @endif
                {{-- Added dynamic tabs for third level menus  --}}
                {{-- Todo @suraj-webkul need to optimize below statement. --}}
                @if (!request()->routeIs('admin.configuration.index'))
                    <x-admin::layouts.tabs />
                @endif

                {{-- Page Content Blade Component --}}
                {{ $slot }}
            </div>
        </div>

        {!! view_render_event('bagisto.shop.layout.content.after') !!}
    </div>

    {!! view_render_event('bagisto.shop.layout.body.after') !!}

    @stack('scripts')
</body>

</html>
