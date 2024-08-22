{{-- SEO Meta Content --}}
@push('meta')
    <meta name="title" content="{{ $sellerCategory->name }}" />
    <meta name="description" content="{{ $sellerCategory->info }}" />
@endPush

<x-shop::layouts :has-footer="false">
    <x-slot:title>
        {{ $area->name . ' - ' . $sellerCategory->name }}
    </x-slot>
    <div class="sn-background-light-green h-full">
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
        <div class="flex gap-6 px-24 py-36 flex-wrap justify-center max-lg:px-1 max-lg:pt-14 max-lg:pb-40 max-lg:gap-3">
            @if ($sellers->count() > 0)
                @foreach ($sellers as $seller)
                    <a href="{{ route('shop.marketplace.show', ['slug' => $seller->slug]) }}"
            			class='flex flex-col gap-2 content-start w-fit relative border border-gray-10 rounded-lg bg-white'>
                        <img src="{{ $seller->logo_url }}" class="w-72 h-72 rounded-t-lg max-lg:h-44 max-lg:w-44 bg-[#f6f6f6]">
                        <div class="sn-color-secondary text-center lg:!text-3xl max-lg:!text-lg pb-2 pr-4">
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
