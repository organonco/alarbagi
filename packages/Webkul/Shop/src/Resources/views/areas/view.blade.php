{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $area->name }}" />
    <meta name="description" content="{{ $area->info }}" />
@endPush

<x-shop::layouts>
    <x-slot:title>
        {{ $area->name }}
    </x-slot>

    <div class="w-full">
        <img class="w-full" src="{{$area->banner_url}}"/>
    </div>

    <div class="w-full flex justify-center pt-10">
        <img src="{{$area->image_url}}" class="w-72 h-72 rounded-lg"> 
    </div>

    <div class="sn-heading-1 text-center sn-color-primary pt-4">
        {{$area->name}}
    </div>

    <div class="">
        
    </div>

</x-shop::layouts>