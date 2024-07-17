{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $area->name }}" />
    <meta name="description" content="{{ $area->info }}" />
@endPush

<x-shop::layouts>
    <x-slot:title>
        {{ $area->name }}
    </x-slot>
    
    <div class="sn-heading-1 text-center sn-color-primary pt-10">
        {{$area->name}}
    </div>

</x-shop::layouts>