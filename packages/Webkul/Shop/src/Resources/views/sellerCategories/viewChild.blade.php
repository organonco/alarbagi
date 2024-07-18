{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $sellerCategory->name }}" />
    <meta name="description" content="{{ $sellerCategory->info }}" />
@endPush

<x-shop::layouts>
    <x-slot:title>
        {{ $sellerCategory->name }}
    </x-slot>

    <div class="w-full">
        <img class="w-full" src="{{ $sellerCategory->banner_url }}" />
    </div>

    <div class="w-full flex justify-center pt-10">
        <img src="{{ $sellerCategory->image_url }}" class="w-72 h-72 rounded-full">
    </div>

    <div class="sn-heading-1 text-center sn-color-primary pt-4">
        {{ $sellerCategory->name }}
    </div>

    <div class="flex gap-6 px-24 py-36 flex-wrap justify-center max-lg:px-6">
        
    </div>

</x-shop::layouts>
