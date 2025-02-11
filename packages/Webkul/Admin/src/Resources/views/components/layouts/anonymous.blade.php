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

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{asset('assets/css/style.css') . '?' . time()}}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-style.css') . '?' . time()}}"/>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"
        rel="stylesheet"
    />

    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" sizes="any">
    <link rel="apple-touch-icon" href="{{asset('assets/images/apple-touch-icon.png')}}">

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
        <x-admin::flash-group />

        {!! view_render_event('bagisto.shop.layout.content.before') !!}

                {{-- Page Content Blade Component --}}
                {{ $slot }}

        {!! view_render_event('bagisto.shop.layout.content.after') !!}
    </div>

    {!! view_render_event('bagisto.shop.layout.body.after') !!}

    @stack('scripts')

    <script type="text/javascript">
        {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
    </script>
</body>

</html>
