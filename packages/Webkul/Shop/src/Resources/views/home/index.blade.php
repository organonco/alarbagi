@php
    $channel = core()->getCurrentChannel();
@endphp

@push('styles')
@endpush

{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? '' }}" />

    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? '' }}" />

    <meta name="keywords" content="{{ $channel->home_seo['meta_keywords'] ?? '' }}" />
@endPush

<x-shop::layouts :has-footer="true">
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    @if (count($desktopBanners['images']))
        <div class="desktop-only">
            <x-shop::carousel :options='$desktopBanners'></x-shop::carousel>
        </div>
    @endif
    @if (count($mobileBanners['images']))
        <div class="mobile-only">
            <x-shop::carousel-mobile :options='$mobileBanners'></x-shop::carousel-mobile>
        </div>
    @endif

    {{-- <div
        class="bg-[#FF6B30] h-[30rem] flex justify-between max-lg:flex-col-reverse max-lg:pb-8 max-lg:items-center max-lg:h-[45rem] max-lg:justify-center">
        <div class="max-lg:mr-0 mr-60 h-full flex justify-center flex-col gap-12 max-lg:h-[20rem]">
            <div
                class="sn-color-primary text-6xl font-extrabold max-lg: text-center max-lg:text-5xl max-lg:px-20 !leading-[1.3]">
                المحل محلك وانت بمحلك
            </div>
            <div class="sn-heading-1 sn-color-primary flex justify-center gap-3 max-lg:flex-col items-center">
                <div
                    class="border-white rounded-md border-2 py-2 sn-heading-3 px-8 flex justify-around gap-2 items-center">
                    <div class="flex flex-col gap-1 justify-center px-4">
                        <div class="text-white text-center">
                            قم بتنزيل التطبيق
                        </div>
                        <div class="text-white  text-center sn-heading-3 px-4 max-lg:px-1">
                            Google Play
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/google-play.png') }}" class="h-10">
                </div>
                <div
                    class="border-white rounded-md border-2 p-2 sn-heading-3 px-8 flex justify-around gap-2 items-center">
                    <div class="flex flex-col gap-1 justify-center px-4">
                        <div class="text-white text-center">
                            قم بتنزيل التطبيق
                        </div>
                        <div class="text-white  text-center sn-heading-3 px-4">
                            App Store
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/apple.png') }}" class="h-10">
                </div>
            </div>
        </div>
        <div class="h-full ml-44 p-3 max-lg:ml-0 max-lg:h-[20rem]">
            <img class="h-full max-lg:h-[20rem]" src="{{ asset('assets/images/header.png') }}">
        </div>
    </div> --}}
    {{-- END TOP BANNER --}}

    {{-- AREAS --}}
    <div
        class="sn-background-grey flex gap-4 px-24 py-36 flex-wrap max-lg:py-12 max-lg:px-1 max-lg:gap-2 justify-evenly">
        @foreach ($areas as $area)
            <a href="{{ route('area.view', $area->id) }}"
                class="w-72 py-8 max-lg:py-1 flex gap-4 flex-col max-lg:gap-2 max-lg:w-24">
                <img src="{{ $area->image_url }}" class="w-72 h-72 rounded-lg max-lg:h-24">
                <div class="sn-color-primary text-center lg:!text-3xl max-lg:!text-sm max-lg:!font-bold">
                    {{ $area->name }}
                </div>
            </a>
        @endforeach
    </div>
    {{-- END AREAS --}}


    {{-- FOOTER --}}
    {{-- END FOOTER --}}

</x-shop::layouts>
