{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $sellerCategory->name }}" />
    <meta name="description" content="{{ $sellerCategory->info }}" />
@endPush

<x-shop::layouts :has-footer="false">
    <x-slot:title>
        {{ $area->name . ' - ' . $sellerCategory->name }}
    </x-slot>
    <div class="sn-background-light-green min-h-screen">
        <div class="w-full">
            <img class="w-full" src="{{ $sellerCategory->banner_url }}" />
        </div>

        <div class="w-full flex justify-center pt-10">
            <img src="{{ $sellerCategory->image_url }}" class="w-72 h-72 rounded-full max-lg:w-40 max-lg:h-40">
        </div>

        <div class="sn-heading-1 text-center sn-color-primary pt-4">
            {{ $area->name }}
        </div>
        <div class="sn-heading-2 text-center sn-color-primary pt-1">
            {{ $sellerCategory->name }}
        </div>
        <div class="flex justify-center gap-4 px-24 py-36 flex-wrap max-lg:py-12 max-lg:px-1 max-lg:gap-2 justify-evenly">
            @if ($sellers->count() > 0)
                @foreach ($sellers as $seller)
                    <a href="{{ route('shop.marketplace.show', ['slug' => $seller->slug]) }}"
            			class='w-72 pb-8 max-lg:pb-1 flex gap-4 flex-col max-lg:gap-2 max-lg:w-24 rounded-lg bg-white'>
                        <img src="{{ $seller->logo_url }}" class="w-72 h-72 rounded-t-lg max-lg:h-24 max-lg:w-24 bg-[#f6f6f6]">
                        <div class="sn-color-secondary text-center lg:!text-3xl max-lg:!text-sm max-lg:!font-bold">
                            {{ $seller->name }}
                        </div>
                    </a>
                @endforeach
            @else
                <div
                    class="grid items-center justify-items-center place-content-center w-[100%] m-auto h-[276px] text-center">
                    <p class="sn-heading-2 sn-color-primary">
                        @lang('shop::app.categories.view.empty-category')
                    </p>
                </div>
            @endif
        </div>
    </div>

</x-shop::layouts>
