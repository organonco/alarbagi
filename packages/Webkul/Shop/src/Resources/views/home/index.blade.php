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

<x-shop::layouts>
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>
    
    {{-- TOP BANNER --}}
    <div class="bg-[#FF6B30] h-[30rem] flex justify-between">
        <div class="mr-60 h-full flex justify-center flex-col gap-12">
            <div class="sn-color-primary text-6xl font-extrabold">
                المحل محلك وانت بمحلك
            </div>
            <div class="sn-heading-1 sn-color-primary flex justify-center gap-3">
                <div class="border-white rounded-md border-2 p-2 sn-heading-3 px-8 flex justify-around gap-2 items-center">
                    <div class="flex flex-col gap-1 justify-center px-4">
                        <div class="text-white text-center">
                            قم بتنزيل التطبيق
                        </div>
                        <div class="text-white  text-center sn-heading-3 px-4">
                            Google Play
                        </div>
                    </div>
                    <img src="{{asset('assets/images/google-play.png')}}" class="h-10">
                </div>
                <div class="border-white rounded-md border-2 p-2 sn-heading-3 px-8 flex justify-around gap-2 items-center">
                    <div class="flex flex-col gap-1 justify-center px-4">
                        <div class="text-white text-center">
                            قم بتنزيل التطبيق
                        </div>
                        <div class="text-white  text-center sn-heading-3 px-4">
                            App Store
                        </div>
                    </div>
                    <img src="{{asset('assets/images/apple.png')}}" class="h-10">
                </div>
            </div>
        </div>
        <div class="h-full ml-44 p-3">
            <img class="h-full" src="{{asset('assets/images/header.png')}}"> 
        </div>
    </div>
    {{-- END TOP BANNER --}}

    {{-- AREAS --}}
    <div class="sn-background-grey flex justify-center gap-4 px-24 py-36 flex-wrap">

        @foreach($areas as $area)
            <div class="w-72 py-8">
                <img src="{{$area->image_url}}" class="w-72 h-72 rounded-lg"> 
                <div class="sn-color-primary sn-heading-3 pt-6 text-center">
                    {{$area->name}}
                </div>
            </div>
        @endforeach
        
    </div>
    {{-- END AREAS --}}
</x-shop::layouts>
